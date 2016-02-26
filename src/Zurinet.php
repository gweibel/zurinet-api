<?php

use Zurinet\RequestException;

class Zurinet
{
    public function getReviews($id)
    {
        $reviews = [];
        $xpath = $this->load($id);

        $url = $xpath->evaluate('string(.//meta[@property="og:url"]/@content)');

        $nodes = $xpath->query('//div[@itemtype="http://schema.org/Review"]');
        foreach ($nodes as $node) {
            $reviews[] = [
                'date' => new \DateTime($xpath->evaluate('string(.//meta[@itemprop="datePublished"]/@content)', $node)),
                'author' => trim($xpath->evaluate('string(.//meta[@itemprop="author"]/@content)', $node)),
                'rating' => floatval($xpath->evaluate('string(.//meta[@itemprop="ratingValue"]/@content)', $node)),
                'message' => trim($xpath->evaluate('string(.//span[@itemprop="description"]/text())', $node)),
                'url' => $url.'#'.trim($xpath->evaluate('string(.//div[@class="text-success"]/@id)', $node)),
            ];
        }

        return $reviews;
    }

    protected function load($id)
    {
        $response = Requests::get(sprintf('http://zuri.net/zurich/%s/', $id));
        if ($response->status_code != 200) {
            throw new RequestException('Could not fetch response.');
        }

        $doc = new \DOMDocument();
        if (@$doc->loadHTML($response->body) === false) {
            throw new RequestException('Could not parse response.');
        }

        return new \DOMXPath($doc);
    }
}
