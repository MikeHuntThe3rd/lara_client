<?php

namespace App\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

/**
 * Thin client for the LarAPI REST service.
 *
 * Translates API errors into the exceptions Laravel already knows how to render:
 *   401 -> AuthenticationException (redirects to the "login" route)
 *   404 -> 404 page
 *   422 -> ValidationException (redirects back with errors + old input)
 */
class LarApi
{
    private function client(): PendingRequest
    {
        $client = Http::baseUrl(rtrim(config('services.larapi.url'), '/'))
            ->acceptJson()
            ->asJson()
            ->timeout(10);

        $token = session('api_token');

        return $token ? $client->withToken($token) : $client;
    }

    public function get(string $path, array $query = []): Response
    {
        $query = array_filter($query, fn ($value) => filled($value));

        return $this->handle($this->client()->get($path, $query));
    }

    public function post(string $path, array $data = []): Response
    {
        return $this->handle($this->client()->post($path, $data));
    }

    public function patch(string $path, array $data = []): Response
    {
        return $this->handle($this->client()->patch($path, $data));
    }

    public function delete(string $path): Response
    {
        return $this->handle($this->client()->delete($path));
    }

    /** Returns the API token, or null when the credentials are wrong. */
    public function login(string $email, string $password): ?string
    {
        $response = $this->client()->post('/login', compact('email', 'password'));

        if ($response->status() === 401) {
            return null;
        }

        return $this->handle($response)->json('token');
    }

    public function logout(): void
    {
        try {
            $this->client()->post('/logout');
        } catch (\Throwable) {
            // The token is dropped locally either way.
        }

        session()->forget('api_token');
    }

    private function handle(Response $response): Response
    {
        if ($response->successful()) {
            return $response;
        }

        switch ($response->status()) {
            case 401:
                session()->forget('api_token');
                throw new AuthenticationException();
            case 404:
                abort(404);
            case 422:
                throw ValidationException::withMessages(
                    $response->json('errors') ?? ['api' => $response->json('message') ?? 'Invalid data.']
                );
            default:
                $response->throw();
        }

        return $response;
    }
}
