<?php

namespace app\components;

use Yii;
use Aws\S3\S3Client;
use yii\base\Component;
use yii\web\UploadedFile;

class S3Storage extends Component
{
    public $key;
    public $secret;
    public $bucket = 'mindplacediploma';
    public $region = 'eu-north-1';
    public $clientConfig;
    private $_client;

    public function getClient()
    {
        if (!$this->_client) {
            if (!$this->key || !$this->secret) {
                Yii::warning('AWS credentials not set properly', 'therapist-join');
                return null;
            }

            $this->_client = new S3Client([
                'version' => 'latest',
                'region' => $this->region,
                'credentials' => [
                    'key' => $this->key,
                    'secret' => $this->secret,
                ],
            ]);
        }

        return $this->_client;
    }


    public function init()
    {
        parent::init();

        if ($this->clientConfig) {
            $credentials = $this->clientConfig['credentials'] ?? [];
            $this->key = $credentials['key'] ?? $this->key;
            $this->secret = $credentials['secret'] ?? $this->secret;
            $this->region = $this->clientConfig['region'] ?? $this->region;
            Yii::info("S3Storage init: key={$this->key}, secret=" . ($this->secret ? 'set' : 'empty'), 'therapist-join');
        }

        if (!$this->key || !$this->secret) {
            Yii::warning('AWS credentials not set properly', 'therapist-join');
            return;
        }

        $this->_client = new S3Client([
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret,
            ],
        ]);
    }

    public function upload(UploadedFile|string $file, string $path)
    {
        if (!$this->client) {
            return false;
        }

        if (is_string($file)) {
            $stream = fopen($file, 'rb');
        } else {
            $stream = fopen($file->tempName, 'rb');
        }

        $result = $this->client->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $path,
            'Body'   => $stream,
            'ContentType' => mime_content_type($file),
        ]);

        fclose($stream);

        return [
            'name' => basename($file),
            'path' => $path,
            'url' => $result['ObjectURL'] ?? null,
        ];
    }



    public function delete($filePath)
    {
        if (!$this->client) {
            return false;
        }

        try {
            $this->client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $filePath,
            ]);

            return true;
        } catch (\Exception $e) {
            Yii::error('Error deleting from S3: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }

    public function testConnection()
    {
        if (!$this->client) {
            Yii::error('S3 client is not initialized', 'therapist-join');
            return false;
        }

        try {
            $this->client->listBuckets();
            return true;
        } catch (\Exception $e) {
            Yii::error('S3 connection test failed: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }
}
