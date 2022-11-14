<?php

namespace Sifon\LaravelUsageCheckPackage;

use GuzzleHttp\Client;

class LaravelUsageCheckPackage
{
    /**
     * Check if site uses Laravel by checking its cookies
     * Returns array of sites that use Laravel
     *
     * @param array $domains
     * @return array
     */
    public static function check($domains)
    {
        $regExp = '/[^\s]+(?:_session)\b/';
        $laravelSites = [];

        foreach ($domains as $domain) {
            $client = new Client(['cookies' => true]);
            $client->request('GET', $domain);
            $cookies = $client->getConfig('cookies');
            $cookies->toArray();
            foreach ($cookies as $cookie) {
                $cookieArray = $cookie->toArray();
                $match = preg_match($regExp, $cookieArray['Name']);
                if ($match) {
                    $laravelSites[] = $domain;
                }
            }
        }
        return $laravelSites;
    }

    /**
     * Returns txt file of all sites that use Laravel
     *
     * @param  array $domains
     * @return void
     */
    public static function output($domains)
    {
        $file = 'domains.txt';
        $txt = fopen($file, 'w') or die("Unable to open file!");
        fwrite($txt, implode(PHP_EOL, $domains));
        fclose($txt);
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: text/plain");
        readfile($file);
        unlink($file);
    }
}
