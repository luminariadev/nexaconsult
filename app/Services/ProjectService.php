<?php

namespace App\Services;

use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use App\Models\Project;

class ProjectService
{
    protected ?Client $mongoClient = null;
    protected $collection = null;
    protected bool $useMongo = false;

    public function __construct()
    {
        $this->initDriver();
    }

    protected function initDriver(): void
    {
        if (extension_loaded('mongodb')) {
            try {
                $uri = env('MONGODB_URI', 'mongodb://127.0.0.1:27017');
                $client = new Client($uri, [], ['serverSelectionTimeoutMS' => 800]);
                $client->listDatabases();
                $this->mongoClient = $client;
                $dbName = env('MONGODB_DATABASE', 'nexaconsult');
                $db = $this->mongoClient->selectDatabase($dbName);
                $this->collection = $db->selectCollection('projects');
                $this->useMongo = true;
            } catch (\Throwable $e) {
                $this->useMongo = false;
            }
        } else {
            $this->useMongo = false;
        }
    }

    public function isUsingMongo(): bool
    {
        return $this->useMongo;
    }

    /**
     * CREATE PROJECT
     */
    public function create(array $data)
    {
        $data['status'] = $data['status'] ?? 'active';
        $data['created_at'] = now()->toIso8601String();
        $data['updated_at'] = now()->toIso8601String();

        if ($this->useMongo && $this->collection) {
            $result = $this->collection->insertOne($data);
            return $this->findById((string)$result->getInsertedId());
        }

        // Eloquent
        $project = Project::create([
            'user_id'     => $data['user_id'],
            'name'        => $data['name'],
            'description' => $data['description'] ?? '',
            'user_prompt' => $data['user_prompt'] ?? '',
            'tasks'       => $data['tasks'] ?? [],
            'status'      => $data['status']
        ]);

        return $this->formatProject($project);
    }

    /**
     * FIND BY USER
     */
    public function findByUser($userId): array
    {
        if ($this->useMongo && $this->collection) {
            $cursor = $this->collection->find(
                ['user_id' => (string) $userId],
                ['sort' => ['created_at' => -1]]
            );
            $results = [];
            foreach ($cursor as $doc) {
                $results[] = $this->formatMongoDoc($doc);
            }
            return $results;
        }

        $projects = Project::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $projects->map(fn($p) => $this->formatProject($p))->toArray();
    }

    /**
     * FIND BY ID AND USER
     */
    public function findByIdAndUser($id, $userId)
    {
        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($id);
            } catch (\Throwable $e) {
                $objId = $id;
            }
            $doc = $this->collection->findOne([
                '_id' => $objId,
                'user_id' => (string) $userId
            ]);
            return $doc ? $this->formatMongoDoc($doc) : null;
        }

        $project = Project::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        return $project ? $this->formatProject($project) : null;
    }

    /**
     * FIND BY ID
     */
    public function findById($id)
    {
        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($id);
            } catch (\Throwable $e) {
                $objId = $id;
            }
            $doc = $this->collection->findOne(['_id' => $objId]);
            return $doc ? $this->formatMongoDoc($doc) : null;
        }

        $project = Project::find($id);
        return $project ? $this->formatProject($project) : null;
    }

    /**
     * UPDATE PROJECT
     */
    public function update($id, $userId, array $data)
    {
        $data['updated_at'] = now();

        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($id);
            } catch (\Throwable $e) {
                $objId = $id;
            }
            $this->collection->updateOne(
                ['_id' => $objId, 'user_id' => (string) $userId],
                ['$set' => $data]
            );
            return $this->findByIdAndUser($id, $userId);
        }

        $project = Project::where('id', $id)->where('user_id', $userId)->first();
        if ($project) {
            $project->update($data);
            return $this->formatProject($project);
        }

        return null;
    }

    /**
     * DELETE PROJECT
     */
    public function delete($id, $userId): bool
    {
        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($id);
            } catch (\Throwable $e) {
                $objId = $id;
            }
            $res = $this->collection->deleteOne([
                '_id' => $objId,
                'user_id' => (string) $userId
            ]);
            return $res->getDeletedCount() > 0;
        }

        $deleted = Project::where('id', $id)->where('user_id', $userId)->delete();
        return $deleted > 0;
    }

    /**
     * TOGGLE TASK
     */
    public function toggleTask($id, $userId, int $taskIndex)
    {
        $project = $this->findByIdAndUser($id, $userId);
        if (!$project) return null;

        $tasks = $project['tasks'] ?? [];
        if (!isset($tasks[$taskIndex])) return false;

        $tasks[$taskIndex]['done'] = !($tasks[$taskIndex]['done'] ?? false);
        $tasks[$taskIndex]['updated_at'] = now()->toISOString();

        $this->update($id, $userId, ['tasks' => $tasks]);
        return $tasks;
    }

    /**
     * ADD TASKS
     */
    public function addTasks($id, $userId, array $newTasks)
    {
        $project = $this->findByIdAndUser($id, $userId);
        if (!$project) return null;

        $tasks = $project['tasks'] ?? [];
        foreach ($newTasks as $t) {
            $tasks[] = [
                'task'       => is_array($t) ? ($t['task'] ?? '') : (string)$t,
                'done'       => is_array($t) ? ($t['done'] ?? false) : false,
                'created_at' => now()->toISOString()
            ];
        }

        $this->update($id, $userId, ['tasks' => $tasks]);
        return $tasks;
    }

    /**
     * EDIT TASK
     */
    public function editTask($id, $userId, int $taskIndex, string $newText)
    {
        $project = $this->findByIdAndUser($id, $userId);
        if (!$project) return null;

        $tasks = $project['tasks'] ?? [];
        if (!isset($tasks[$taskIndex])) return false;

        $tasks[$taskIndex]['task'] = $newText;
        $tasks[$taskIndex]['updated_at'] = now()->toISOString();

        $this->update($id, $userId, ['tasks' => $tasks]);
        return $tasks;
    }

    /**
     * DELETE TASK
     */
    public function deleteTask($id, $userId, int $taskIndex)
    {
        $project = $this->findByIdAndUser($id, $userId);
        if (!$project) return null;

        $tasks = $project['tasks'] ?? [];
        if (!isset($tasks[$taskIndex])) return false;

        array_splice($tasks, $taskIndex, 1);
        $this->update($id, $userId, ['tasks' => $tasks]);
        return $tasks;
    }

    /**
     * STATS FOR USER
     */
    public function getUserStats($userId): array
    {
        $projects = $this->findByUser($userId);
        $total = count($projects);
        $active = 0;
        $completed = 0;
        $totalTasks = 0;
        $completedTasks = 0;

        foreach ($projects as $p) {
            $status = $p['status'] ?? 'active';
            $pTasks = $p['tasks'] ?? [];
            $tCount = count($pTasks);
            $doneCount = 0;
            foreach ($pTasks as $t) {
                if (!empty($t['done'])) $doneCount++;
            }
            $totalTasks += $tCount;
            $completedTasks += $doneCount;

            if ($status === 'completed' || ($tCount > 0 && $doneCount === $tCount)) {
                $completed++;
            } else {
                $active++;
            }
        }

        return [
            'total_projects'  => $total,
            'active_projects' => $active,
            'completed_projects' => $completed,
            'total_tasks'     => $totalTasks,
            'completed_tasks' => $completedTasks,
            'progress_avg'    => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0
        ];
    }

    protected function formatMongoDoc($doc): array
    {
        $arr = (array) $doc;
        $arr['_id'] = (string) ($doc->_id ?? $doc['id'] ?? '');
        $arr['id'] = $arr['_id'];

        if (isset($arr['created_at'])) {
            if (is_object($arr['created_at']) && method_exists($arr['created_at'], 'toDateTime')) {
                $arr['created_at'] = $arr['created_at']->toDateTime()->format(\DateTime::ATOM);
            } elseif (is_object($arr['created_at']) && method_exists($arr['created_at'], 'toISOString')) {
                $arr['created_at'] = (string) $arr['created_at'];
            } elseif (is_object($arr['created_at'])) {
                $arr['created_at'] = now()->toIso8601String();
            }
        } else {
            $arr['created_at'] = now()->toIso8601String();
        }

        if (isset($arr['updated_at'])) {
            if (is_object($arr['updated_at']) && method_exists($arr['updated_at'], 'toDateTime')) {
                $arr['updated_at'] = $arr['updated_at']->toDateTime()->format(\DateTime::ATOM);
            } elseif (is_object($arr['updated_at']) && method_exists($arr['updated_at'], 'toISOString')) {
                $arr['updated_at'] = (string) $arr['updated_at'];
            } elseif (is_object($arr['updated_at'])) {
                $arr['updated_at'] = now()->toIso8601String();
            }
        } else {
            $arr['updated_at'] = now()->toIso8601String();
        }

        if (isset($arr['tasks'])) {
            $arr['tasks'] = (array) $arr['tasks'];
            $formattedTasks = [];
            foreach ($arr['tasks'] as $t) {
                $formattedTasks[] = (array) $t;
            }
            $arr['tasks'] = $formattedTasks;
        }
        return $arr;
    }

    protected function formatProject(Project $project): array
    {
        $arr = $project->toArray();
        $arr['_id'] = (string) $project->id;
        $arr['id'] = (string) $project->id;
        return $arr;
    }
}
