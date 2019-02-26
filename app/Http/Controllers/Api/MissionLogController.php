<?php

namespace Koodilab\Http\Controllers\Api;

use Koodilab\Http\Controllers\Controller;
use Koodilab\Transformers\MissionLogTransformer;
use Koodilab\Notifications\MissionLogCreated;

class MissionLogController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('player');
    }

    /**
     * Get the mission logs in json format.
     *
     * @param MissionLogTransformer $transformer
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(MissionLogTransformer $transformer)
    {
        /** @var \Koodilab\Models\User $user */
        $user = auth()->user();

        $user->deleteNotificationsByType(MissionLogCreated::class);

        return $transformer->transformCollection(
            $user->paginateMissionLogs()
        );
    }
}
