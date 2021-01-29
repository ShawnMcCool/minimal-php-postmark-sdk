<?php namespace MinimalPhpPostmarkSdk;

class PostmarkApi
{
    public function __construct(
        private string $postmarkServerToken
    ) {
    }

    /**
     * http://developer.postmarkapp.com/developer-send-api.html (send batch email)
     */
    public function batch(array $batchedMailing, int $chunkSize = 500): array
    {
        $batches = array_chunk($batchedMailing, $chunkSize);

        $responses = [];

        foreach ($batches as $batch) {
            $responses[] = $this->post(
                'https://api.postmarkapp.com/email/batch',
                array_map(
                    fn(Mailing $mailing) => $mailing->serializeToApi(),
                    $batch
                )
            );
        }

        return array_map(
            fn($response) => $this->responseObject(
                json_decode($response)[0]
            ),
            $responses
        );
    }

    /**
     * http://developer.postmarkapp.com/developer-send-api.html (send a single email)
     */
    public function single(Mailing $mailing): SuccessResponse|ErrorResponse
    {
        $url =
            $mailing->isTemplateMail()
                ? 'https://api.postmarkapp.com/email/withTemplate'
                : 'https://api.postmarkapp.com/email';

        $response = $this->post($url, $mailing->serializeToApi());

        return $this->responseObject($response);
    }

    private function post($url, array $fields): ErrorResponse|SuccessResponse
    {
        $ch = curl_init();

        # request
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
                   'Accept: application/json',
                   'Content-Type: application/json',
                   'X-Postmark-Server-Token: ' . $this->postmarkServerToken,
               ]
        );

        # payload
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        # execute
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     *
     * # Success
     * {
     *     "To": "example@email.com",
     *     "SubmittedAt": "2019-02-21T13:20:44.13264-05:00",
     *     "MessageID": "15b08cei-1526-429f-aea2-5ab93e2151f6",
     *     "ErrorCode": 0,
     *     "Message": "OK"
     * }
     *
     * # Error
     * {
     *     "ErrorCode": 400,
     *     "Message": "The 'From' address you supplied (Example Name<example@email.com>) is not a Sender Signature on your account. Please add and confirm this address in order to be able to use it in the 'From' field of your messages."
     * }
     */
    private function responseObject($r): SuccessResponse|ErrorResponse
    {
        if ($r->ErrorCode === 0) {
            return new SuccessResponse($r->MessageID, Email::fromString($r->To), Timestamp::now());
        }

        if (is_null($r->ErrorCode)) {
            throw new \Exception('unknown failure ' . var_export($r));
        }

        return new ErrorResponse($r->ErrorCode, $r->Message);
    }
}