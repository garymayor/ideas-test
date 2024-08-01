<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl\Curl;

class SearchController extends Controller
{

    public function index()
    {
        // Show the search form with CSRF token included
        return view('search')->with(['csrf_token' => csrf_token()]);
    }

    public function results(Request $request)
    {
        // Get the search from the browser
        $query = $request->input('query');

        // Connect to OpenLlama server using curl
        $c = curl_init('http://localhost:11434/v1/chat/completions');
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, 1);

        // Set headers to json
        curl_setopt($c, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        // Set JSON data
        $jsonData = json_encode([
            "model" => "llama3.1",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a helpful assistant."
                ],
                [
                    "role" => "user",
                    "content" => $query
                ]
            ]
        ]);

        // Send JSON data as the body of the request
        curl_setopt($c, CURLOPT_POSTFIELDS, $jsonData);

        // Execute the curl command
        $response = curl_exec($c);
        
        // Decode JSON response
        $data = json_decode($response, true);

        // Print the response to a file
        $data2 = print_r($data, TRUE);
        file_put_contents('queryresponse.log', $query . "\n" . $data2);
        
        // Close cURL session
        curl_close($c);

        $response = $data['choices'][0]['message']['content'];

        // Display the search results to the user
        return view('results', ['response' => $response]);

    }
}
