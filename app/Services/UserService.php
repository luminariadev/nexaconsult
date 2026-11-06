<?php

namespace App\Services;

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

class UserService
{
    protected $collection;

    public function __construct()
    {
        $client = new Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
        $db = $client->selectDatabase(env('MONGODB_DATABASE', 'nexaconsult'));
        $this->collection = $db->selectCollection('users');
    }

    public function all()
    {
        $data = $this->collection->find()->toArray();
        return array_map(fn($d) => $this->format($d), $data);
    }


    public function find($id)
    {
        $doc = $this->collection->findOne(['_id' => new ObjectId($id)]);
        return $this->format($doc);
    }


    public function create(array $data)
    {
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $result = $this->collection->insertOne($data);
        $data['_id'] = $result->getInsertedId();

        return $data;
    }

    public function update($id, array $data)
    {
        $data['updated_at'] = now();

        $this->collection->updateOne(
            ['_id' => new ObjectId($id)],
            ['$set' => $data]
        );

        return $this->find($id);
    }

    public function delete($id)
    {
        $result = $this->collection->deleteOne(['_id' => new ObjectId($id)]);

        return [
            'deleted' => $result->getDeletedCount() > 0
        ];
    }

    public function paginate($page = 1, $limit = 10)
    {
        // Pastikan integer
        $page  = max(1, (int) $page);
        $limit = max(1, (int) $limit);

        $skip = ($page - 1) * $limit;

        $cursor = $this->collection->find(
            [],
            [
                'skip'  => $skip,
                'limit' => $limit,
            ]
        );

        $data = $cursor->toArray();

        $total = $this->collection->countDocuments();

        return [
            'data'       => array_map(fn($d) => $this->format($d), $data),
            'page'       => $page,
            'limit'      => $limit,
            'total'      => $total,
            'total_page' => ceil($total / $limit),
        ];
    }

    public function filter(array $params)
    {
        // --- 1. Base Query (kosong berarti ambil semua) ---
        $filter = [];

        // --- 2. Searching ---
        if (!empty($params['search'])) {
            $text = $params['search'];

            // Contoh search di beberapa kolom sekaligus
            $filter['$or'] = [
                ['name'  => ['$regex' => $text, '$options' => 'i']],
                ['email' => ['$regex' => $text, '$options' => 'i']],
                ['username' => ['$regex' => $text, '$options' => 'i']],
            ];
        }

        // --- 3. Filtering (role, status, dan lainnya) ---
        $allowedFilters = ['role', 'status', 'gender'];

        foreach ($allowedFilters as $key) {
            if (!empty($params[$key])) {
                $filter[$key] = $params[$key];
            }
        }

        // --- 4. Sorting ---
        $sort = [];
        if (!empty($params['sort'])) {
            // format: field:direction → example: created_at:desc
            [$field, $direction] = explode(':', $params['sort']);

            $sort[$field] = strtolower($direction) === 'desc' ? -1 : 1;
        } else {
            // default sorting by created_at desc
            $sort = ['created_at' => -1];
        }

        // --- 5. Pagination ---
        $page = isset($params['page']) ? max(1, (int) $params['page']) : 1;
        $limit = isset($params['limit']) ? max(1, (int) $params['limit']) : 10;

        $skip = ($page - 1) * $limit;

        // --- Query Mongo ---
        $cursor = $this->collection->find(
            $filter,
            [
                'skip'  => $skip,
                'limit' => $limit,
                'sort'  => $sort
            ]
        );

        $data = array_map(fn($d) => $this->format($d), $cursor->toArray());

        $total = $this->collection->countDocuments($filter);

        return [
            'status' => 'success',
            'data' => $data,
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'total_page' => ceil($total / $limit)
        ];
    }


    private function format($document)
    {
        if (!$document) return null;

        $doc = (array) $document;

        // Convert _id → id (string)
        if (isset($doc['_id'])) {
            $doc['id'] = (string) $doc['_id'];
            unset($doc['_id']);
        }

        return $doc;
    }
}
