<?php

class ContactLogger
{

    protected $emails = array(
        'ventasusados@crediq.com',
    );

    protected $file = './leads.csv';

    public function getNextTo()
    {
        $last = explode(',', $this->tail($this->file, 1));

        if (isset($last[1])) {
            $index = array_search($last[1], $this->emails);

            if (!($index === false) && isset($this->emails[$index + 1])) {
                return $this->emails[$index + 1];
            }
        }

        return $this->emails[0];
    }

    public function addLine($to, $email, $button, $name, $data_auto)
    {
        file_put_contents(
            $this->file, date('Y-m-d H:i') . ",{$to},\"{$button}\",\"{$name}" .
            "\",\"{$email}\",\"{$phone}\",\"{$data_auto['marca']}" .
            " {$data_auto['modelo']} {$data_auto['year']} (" .
            "{$data_auto['id_automovil']})\"\n", FILE_APPEND
        );
    }

    protected function tail($filename, $lines = 10, $buffer = 4096)
    {
        // Open the file
        $f = fopen($filename, "rb");

        // Jump to last character
        fseek($f, -1, SEEK_END);

        // Read it and adjust line number if necessary
        // (Otherwise the result would be wrong if file doesn't end with a blank line)
        if (fread($f, 1) != "\n") {
            $lines -= 1;
        }

        // Start reading
        $output = '';
        $chunk = '';

        // While we would like more
        while (ftell($f) > 0 && $lines >= 0) {
            // Figure out how far back we should jump
            $seek = min(ftell($f), $buffer);

            // Do the jump (backwards, relative to where we are)
            fseek($f, -$seek, SEEK_CUR);

            // Read a chunk and prepend it to our output
            $output = ($chunk = fread($f, $seek)) . $output;

            // Jump back to where we started reading
            fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);

            // Decrease our line counter
            $lines -= substr_count($chunk, "\n");
        }

        // While we have too many lines
        // (Because of buffer size we might have read too many)
        while ($lines++ < 0) {
            // Find first newline and remove all text before that
            $output = substr($output, strpos($output, "\n") + 1);
        }

        // Close file and return
        fclose($f);
        return $output;
    }

}
