<?php

namespace App\Http\Controllers;

trait PolymorphicResponse
{
    /**
     * Look up object based on type and id for polymorphic controller calls
     *
     * @param $type
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getObject($type, $id)
    {
        // Get Model
        $model = 'App\\Models\\' . ucfirst($type);
        if (!class_exists($model)) {
            return response()->json(['success' => false, 'message' => 'Invalid upload type of "' . $type . '"'], 400);
        }

        // Get Object
        $object = $model::find($id);
        if (!$object) {
            return response()->json(['success' => false, 'message' => 'Object not found for ' . $type . ': #' . $id], 404);
        }

        return $object;
    }
}