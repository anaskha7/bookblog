<?php

class WebhookClient
{
    public static function send(string $event, array $payload): void
    {
        $url = N8N_WEBHOOK_URL;
        $data = [
            'event' => $event,
            'payload' => $payload,
            'token' => N8N_WEBHOOK_TOKEN,
            'timestamp' => time(),
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_exec($ch);
        curl_close($ch);
    }
}
