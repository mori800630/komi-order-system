<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 環境変数からBasic認証の設定を取得
        $username = env('BASIC_AUTH_USERNAME');
        $password = env('BASIC_AUTH_PASSWORD');
        
        // Basic認証が設定されていない場合はスキップ
        if (empty($username) || empty($password)) {
            return $next($request);
        }

        // Basic認証ヘッダーをチェック
        $authHeader = $request->header('Authorization');
        
        if (!$authHeader || !str_starts_with($authHeader, 'Basic ')) {
            return response('Unauthorized', 401)
                ->header('WWW-Authenticate', 'Basic realm="Komi Order System"');
        }

        // Basic認証の認証情報をデコード
        $credentials = base64_decode(substr($authHeader, 6));
        list($user, $pass) = explode(':', $credentials, 2);

        // 認証情報をチェック
        if ($user !== $username || $pass !== $password) {
            return response('Unauthorized', 401)
                ->header('WWW-Authenticate', 'Basic realm="Komi Order System"');
        }

        return $next($request);
    }
}
