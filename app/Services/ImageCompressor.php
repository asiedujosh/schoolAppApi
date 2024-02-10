<?php

namespace App\Services;

use Tinify;

class ImageCompressor
{
    public function compress($sourceData)    
    {
        // if (class_exists('Tinify\Tinify')) {
        //     // The Tinify class is defined, you can use it
        //     // use Tinify\Tinify;
        // // Get an array of method names for the Tinify class
        //         $methods = get_class_methods(Tinify::class);

        //         // Output the list of methods
        //         echo "Methods available in Tinify class:\n";
        //         foreach ($methods as $method) {
        //             echo $method . "\n";
        //         }
        //     // Your code here...
        //     //return "Tinify is available";
        //     // For example, create an instance of Tinify
        //     // $tinifyInstance = new Tinify();
        // }
        $resized = Tinify::fromFile("unoptimized.jpg");
        Tinify::setKey(config('services.tinify.api_key'));

        try {
            $resized = Tinify::fromFile("unoptimized.jpg");
            $resized->toFile("optimized.jpg");
            // ->resize(array(
            //     "method" => "fit",
            //     "width" => 150,
            //     "height" => 100
            // ));

            return $resized;
        } catch (\Tinify\Exception $e) {
            // Handle exceptions (e.g., invalid API key, exceeded usage, etc.)
            // You might want to log the error or throw a custom exception.
            return response()->json(['error' => 'Tinify API error: ' . $e->getMessage()], 500);
            // return null;
        }
    }
}
