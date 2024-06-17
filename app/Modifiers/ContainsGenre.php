<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class ContainsGenre extends Modifier
{
    /**
     * Modify a value.
     *
     * @param mixed  $value    The value to be modified
     * @param array  $params   Any parameters used in the modifier
     * @param array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        // Ensure required parameters are present
        if (!isset($params[0]) || !isset($params[1])) {
            return false;
        }

        // Extract parameters
        $genres = $params[0]; // Array of genres
        $genre = $params[1]; // Genre name to check

        // Check if the genre exists in the genres array
        return in_array($genre, $genres);
    }
}
