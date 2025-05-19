
<?php include 'includes/header.php'; ?>

<style>
    :root {
        --primary-color: #007B7F;
        --accent-color: #F9A825;
        --bg-color: #f9fafb;
        --text-color: #212529;
        --muted-text: #6c757d;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
        margin: 0; padding: 0;
    }

    .planner-container {
        max-width: 1200px;
        margin: 40px auto;
        border-radius: 15px;
        padding: 40px 30px;
    }

    h1 {
        color: var(--primary-color);
        font-size: 2.8rem;
        text-align: center;
        margin-bottom: 15px;
        font-weight: bold;
    }

    p.lead {
        text-align: center;
        color: var(--muted-text);
        font-size: 1.2rem;
        margin-bottom: 40px;
    }

    form {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
    }

    input[type="text"] {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #aaa;
        border-radius: 12px;
        font-size: 1rem;
        outline-color: var(--primary-color);
    }

    button {
        background-color:  #007B7F;
        border: none;
        padding: 12px 25px;
        color: white;
        font-size: 1rem;
        border-radius: 12px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #005f60;
    }

    .result {
        background-color: #e9f7ff;
        border-left: 6px solid var(--primary-color);
        border-radius: 12px;
        padding: 20px 25px;
        font-size: 1.1rem;
        line-height: 1.6;
        white-space: pre-wrap;
        color: #004d66;
    }
</style>

<?php
$responseText = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preference = trim(htmlspecialchars($_POST['preference']));

    // Your Google Gemini API key
    $api_key = 'AIzaSyA1EsRY01guSwu3cfpx07YjVoMkCekns1I';

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$api_key";

    $promptText = "Suggest 5 travel destinations in Uttarakhand, India that match the preference: '$preference'. Only include places in Uttarakhand. For each destination, provide 1-2 sentences explaining why it fits the preference.";

    $postData = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $promptText]
                ]
            ]
        ]
    ];

    $headers = [
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        $responseText = "Curl error: " . curl_error($ch);
    } else {
        $response = json_decode($result, true);
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            $responseText = nl2br(htmlspecialchars($response['candidates'][0]['content']['parts'][0]['text']));
        } else {
            $responseText = "No suggestions found. Please try again.";
        }
    }

    curl_close($ch);
}
?>

<div class="planner-container">
    <h1>Plan Your Trip to Uttarakhand</h1>
    <p class="lead">Enter your travel preferences to get personalized destination suggestions in Uttarakhand.</p>
    <form method="POST" action="">
        <input type="text" name="preference" placeholder="e.g. Snow, Waterfalls, Mountains" required />
        <button type="submit">Get Suggestions</button>
    </form>

    <?php if (!empty($responseText)) : ?>
        <div class="result">
            <strong>Recommended Destinations:</strong><br />
            <?= $responseText ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
