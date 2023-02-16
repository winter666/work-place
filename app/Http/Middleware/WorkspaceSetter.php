<?php

namespace App\Http\Middleware;

use App\Models\Workspace;
use Backpack\CRUD\app\Exceptions\AccessDeniedException;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkspaceSetter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!($user = backpack_user())) {
            return $this->respondToUnauthorizedRequest($request);
        }

        try {
            $workspace = null;
            if ($request->workspace instanceof Workspace) {
                $workspaceId = $request->workspace->id;
                $workspace = $request->workspace;
            } else {
                $workspaceId = $request->workspace;
            }

            if ($user->is_admin && is_null($workspace)) {
                $workspace = Workspace::query()->findOrFail($workspaceId);
            } elseif (!$user->is_admin) {
                $workspace = $user->workspaces()->findOrFail($workspaceId);
            }

            $workspace->connect();
        } catch (ModelNotFoundException $e) {
            return $this->respondToUnauthorizedRequest($request, 404);
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), $e->getTrace());
            return response('Server Error', 500);
        }

        return $next($request);
    }

    private function respondToUnauthorizedRequest($request, $code = 401)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), $code);
        } else {
            return match ($code) {
                401 => redirect()->guest(backpack_url('login')),
                404 => throw new AccessDeniedException(),
            };
        }
    }
}
