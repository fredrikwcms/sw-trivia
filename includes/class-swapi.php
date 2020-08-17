<?php 
/** 
*   Functions for communicating with the Star Wars API
*/

function swapi_get_url($url) {
    $response = wp_remote_get($url);
    if (is_wp_error($response)) {
        return false;
    }
    return json_decode(wp_remote_retrieve_body($response));
}

function swapi_get($endpoint, $id = null, $expiry = 3600) {
    $transient_key = "swapi_get_{$endpoint}";

    if ($id) {
        $transient_key .= "_{$id}";
    }
    $items = get_transient($transient_key);

    if (!$items) {
        if ($id) {
            $items = swapi_get_url("https://swapi.dev/api/{$endpoint}/{$id}");
        }   else {
            $items = [];
            $url = "https://swapi.dev/api/{$endpoint}";
            while ($url) {
                $data = swapi_get_url($url);
                if (!$data) {
                    return false;
                }
                $items = array_merge($items, $data->results);

                $url = $data->next;
            }
        }


        // save for future use
        set_transient($transient_key, $items, $expiry);
    }

    // return items
    return $items;
}

function swapi_get_films() {
    return swapi_get('films');
}
function swapi_get_starships() {
    return swapi_get('starships');
}

function swapi_get_planets() {
    return swapi_get('planets');
}

function swapi_get_planet($planet_id) {
    return swapi_get('planets', $planet_id);
}