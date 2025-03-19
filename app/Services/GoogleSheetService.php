<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected $client;
    protected $service;
    protected $spreadsheetId; // Replace with your actual Sheet ID

    public function __construct()
    {
        $this->spreadsheetId = '125GHYKqB2Ymtd265s4wQiCFQHXB5SJ8BmO6-xmOaIdI'; // Get this from your Google Sheet URL

        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google-sheets.json'));
        $this->client->addScope(Sheets::SPREADSHEETS_READONLY);

        $this->service = new Sheets($this->client);
    }

    public function getSheetData($range = 'Form responses 1!A2:I') // Adjust range as needed
    {
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues();
    }
}
