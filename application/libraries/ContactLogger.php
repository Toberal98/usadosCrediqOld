<?php

require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

class ContactLogger
{

    protected $emails = array(
        'ventasusados@crediq.com',
    );

    protected $file = './leads.csv';

    protected $APPLICATION_NAME;
    protected $CREDENTIALS_PATH;
    protected $CLIENT_SECRET_PATH;
    protected $SCOPES;
    protected $sheets;
    protected $client;
    protected $spreadsheetId = '1Du4OM8LjQ4dVb9JOebF9eh1ydbDGjcqTQbePUhY8LN0';

    public function __construct()
    {
        date_default_timezone_set('America/El_Salvador');

        $BASEPATH = dirname(dirname(__FILE__));

        $this->APPLICATION_NAME = 'Google Sheets API PHP Quickstart';
        $this->CREDENTIALS_PATH = "{$BASEPATH}/google-credentials.json";
        $this->CLIENT_SECRET_PATH = "{$BASEPATH}/client_id.json";
        $this->SCOPES = implode(' ', array(
            Google_Service_Sheets::SPREADSHEETS)
        );

        $this->client = $this->getClient();

        ChromePhp::log('Ya pase el cliente');

        

        if ($this->client) {
            $this->sheets = new Google_Service_Sheets($this->client);
        }
    }

    public function setSpreadsheetId($id)
    {
        $this->spreadsheetId = $id;
    }

    public function getNextTo()
    {

        ChromePhp::log('Estoy en NEXT TO');

        if ($this->client) {

            ChromePhp::log('Estoy en NEXT TO Client');

            try {

                ChromePhp::log($result);

              $result = $this->sheets
                  ->spreadsheets_values
                  ->get($this->spreadsheetId, 'A1:E');

              $last = $result->getValues();

              ChromePhp::log($result);

              ChromePhp::log($last);

              if (isset($last[0][1])) {
                  $index = array_search($last[0][1], $this->emails);

                  if (!($index === false) && isset($this->emails[$index + 1])) {
                      return $this->emails[$index + 1];
                  }
              }
            } catch (Exception $e) {

                ChromePhp::log('Estoy en Error');
                echo $e->getMessage(); 
                ChromePhp::log($e);
                exit;
            }

            
        }

        return $this->emails[0];
    }

    public function addLine($to, $email, $button, $name, $phone, $data_auto, $channel)
    {
        try {
            if ($this->client) {
                $range = "A1:H1";

                $values = array(
                    date('Y-m-d H:i'), $to, $button, $name, $email, $phone,
                );

                if ($data_auto) {
                    array_push($values, "{$data_auto['marca']} {$data_auto['modelo']} {$data_auto['year']} ({$data_auto['id_automovil']})");
                } else {
                    array_push($values, "");
                }

                array_push($values, $channel);

                $valueRange = new Google_Service_Sheets_ValueRange();

                $valueRange->setValues(compact('values'));

                $conf = array("valueInputOption" => "RAW");

                $this->sheets->spreadsheets_values
                    ->append($this->spreadsheetId, $range, $valueRange, $conf);
            } else {
                echo 'no';
            }
        } catch (Exception $e) {
            echo $e->getMessage(); exit;
        }
    }

    protected function getClient()
    {

        $client = new Google_Client();
        $client->setApplicationName($this->APPLICATION_NAME);
        $client->setScopes($this->SCOPES);
        $client->setAuthConfig($this->CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $credentialsPath = $this->CREDENTIALS_PATH;

        if (file_exists($credentialsPath)) {

            ChromePhp::log('Estoy en la parte del token');

            $accessToken = json_decode(file_get_contents($credentialsPath), true); 
            
            ChromePhp::log(file_get_contents($credentialsPath));
            ChromePhp::log($accessToken);

            //return null;
        } else {
            return null;
        }

        ChromePhp::log($accessToken);

        $client->setAccessToken($accessToken);

        //if ($client->isAccessTokenExpired()) {
        //    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        //    file_put_contents($credentialsPath, json_encode(array_merge($accessToken, $client->getAccessToken())));
        //}

        ChromePhp::log($client);
        ChromePhp::log('Aqui voy');
        
        return $client;
        
    }

}
