<?php
// Process AJAX requests first before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    
    $preference = isset($_POST['preference']) ? trim($_POST['preference']) : '';
    
    if (empty($preference)) {
        echo json_encode(['error' => 'Please enter your travel preferences']);
        exit;
    }

    $api_key = 'AIzaSyA1EsRY01guSwu3cfpx07YjVoMkCekns1I';
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $api_key;

    $data = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => "Suggest 5 travel destinations in Uttarakhand, India that match the preference: '$preference'. For each destination, provide the following in a structured way:
        1. Name of the destination
        2. A brief 2-3 sentence description of why it matches the preference"
                    ]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.7,
            'topK' => 40,
            'topP' => 0.95,
            'maxOutputTokens' => 1024
        ]
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json'
        ]
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        echo json_encode(['error' => 'API Error: ' . curl_error($ch)]);
    } else if ($httpCode !== 200) {
        $error_response = json_decode($response, true);
        $error_message = isset($error_response['error']['message']) 
            ? $error_response['error']['message'] 
            : 'An error occurred while fetching suggestions.';
        echo json_encode(['error' => $error_message]);
    } else {
        $result = json_decode($response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $result['candidates'][0]['content']['parts'][0]['text'];
            $destinations = [];
            
            // Parse the response into structured data
            $items = explode("\n\n", trim($text));
            foreach ($items as $item) {
                if (!empty(trim($item))) {
                    $lines = explode("\n", trim($item));
                    $title = trim(str_replace(['1.', '2.', '3.', '4.', '5.'], '', $lines[0]));
                    array_shift($lines);  // Remove the title line
                    $description = implode(" ", array_map('trim', $lines));
                    if (!empty($title) && !empty($description)) {
                        $destinations[] = [
                            'title' => $title,
                            'description' => $description
                        ];
                    }
                }
            }
            
            if (empty($destinations)) {
                echo json_encode(['error' => 'No destinations found for your preferences. Please try different keywords.']);
            } else {
                echo json_encode(['success' => true, 'destinations' => $destinations]);
            }
        } else {
            echo json_encode(['error' => 'Invalid response format from the API. Please try again.']);
        }
    }

    curl_close($ch);
    exit;
}

// Process regular form submission
$responseText = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['ajax'])) {
    $preference = trim(htmlspecialchars($_POST['preference']));
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

include 'includes/header.php';
?>

<style>
    :root {
        --primary-color: #007B7F;
        --accent-color: #F9A825;
        --bg-color: #f9fafb;
        --text-color: #212529;
        --muted-text: #6c757d;
        --gradient: linear-gradient(135deg, #007B7F,rgb(24, 98, 91));
        --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    .planner-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }

    .feature-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: var(--primary-color);
    }

    .feature-card h3 {
        color: var(--text-color);
        margin: 0 0 10px 0;
        font-size: 1.4rem;
    }

    .feature-card p {
        color: var(--muted-text);
        margin: 0;
    }

    /* Search Section */
    .search-container {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        margin-bottom: 60px;
    }

    .section-title {
        text-align: center;
        margin-bottom: 30px;
    }

    .section-title h2 {
        color: var(--text-color);
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .section-title p {
        color: var(--muted-text);
        margin: 0;
    }

    form {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
    }

    input[type="text"] {
        flex: 1;
        padding: 15px 20px;
        border: 2px solid #e1e1e1;
        border-radius: 12px;
        font-size: 1rem;
        transition: var(--transition);
    }

    input[type="text"]:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 123, 127, 0.1);
    }

    #searchForm button {
        background: linear-gradient(65deg, #007B7F ,rgb(18, 151, 153) );
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 12px;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    button:hover {
        background: #005f60;
        transform: translateY(-2px);
    }

    /* Destinations Grid */
    .destinations-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-top: 30px;
        padding: 20px;
    }

    .destination-content {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .destination-content:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .destination-title {
        color: var(--primary-color);
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .destination-desc {
        color: var(--text-color);
        margin: 0;
        line-height: 1.6;
        font-size: 1.1rem;
    }

    /* Season Guide */
    .season-guide {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
    }

    .season-tabs {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .season-tab {
        background-color: rgba(128, 128, 128, 0.2); 
        color: var(--primary-color);
        padding: 12px 25px;
        border-radius: 10px;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);

    }

    .season-tab.active,
    .season-tab:hover {
        background: linear-gradient(65deg, #007B7F ,rgb(18, 151, 153) );
        color: white;
    }

    .season-card {
        display: none;
        padding: 30px;
        background: var(--bg-color);
        border-radius: 15px;
    }

    .season-card.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    .season-card h3 {
        color: var(--primary-color);
        margin: 0 0 20px 0;
    }

    .season-card ul {
        padding-left: 20px;
        margin: 15px 0;
    }

    .season-card li {
        margin-bottom: 10px;
        color: var(--text-color);
    }

    /* Loading Animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .planner-container {
            margin: 20px auto;
        }

        form {
            flex-direction: column;
        }

        button {
            width: 100%;
        }

        .season-tabs {
            justify-content: center;
        }

        .season-tab {
            width: calc(50% - 10px);
            text-align: center;
        }
    }

    /* Search Results */
    .search-results {
        margin-top: 30px;
    }

    .intro-text {
        color: var(--text-color);
        font-size: 1.1rem;
        margin-bottom: 20px;
        padding: 20px;
        line-height: 1.6;
    }
</style>

<div class="planner-container">
    <!-- Features Section -->
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">⛰</div>
            <h3>Mountain Adventures</h3>
            <p>Explore majestic peaks and scenic trails</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">☸</div>
            <h3>Spiritual Journey</h3>
            <p>Visit ancient temples and sacred sites</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">☘</div>
            <h3>Natural Beauty</h3>
            <p>Discover pristine lakes and forests</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">✧</div>
            <h3>Cultural Heritage</h3>
            <p>Experience rich local traditions</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-container">
        <div class="section-title">
            <h2>Plan Your Perfect Trip</h2>
            <p>Tell us your preferences and let us suggest the ideal destinations for you</p>
        </div>
        <form id="searchForm">
            <input type="text" name="preference" placeholder="e.g. Snow, Waterfalls, Mountains, Spiritual places" required />
            <input type="hidden" name="ajax" value="1" />
            <button type="submit">Get Suggestions</button>
        </form>
        <div id="loading" style="display: none; text-align: center; margin: 20px 0;">
            <div style="display: inline-block; width: 40px; height: 40px; border: 3px solid #f3f3f3; border-top: 3px solid var(--primary-color); border-radius: 50%; animation: spin 1s linear infinite;"></div>
        </div>
        <div class="search-results">
            <div id="introText" class="intro-text" style="display: none;"></div>
            <div id="destinationsGrid" class="destinations-grid"></div>
        </div>
    </div>

    <!-- Season Guide Section -->
    <div class="season-guide">
        <div class="section-title">
            <h2>Seasonal Travel Guide</h2>
            <p>Discover the best times to visit different regions of Uttarakhand</p>
        </div>
        <div class="season-tabs">
            <button class="season-tab active" data-season="summer">Summer</button>
            <button class="season-tab" data-season="monsoon">Monsoon</button>
            <button class="season-tab" data-season="autumn">Autumn</button>
            <button class="season-tab" data-season="winter">Winter</button>
        </div>
        <div class="season-content">
            <div class="season-card active" data-season="summer">
                <h3>Summer (March - June)</h3>
                <p>Perfect for:</p>
                <ul>
                    <li>Valley of Flowers trek</li>
                    <li>Char Dham Yatra</li>
                    <li>Wildlife sanctuaries</li>
                </ul>
                <p>Temperature: 20°C - 35°C</p>
            </div>
            <div class="season-card" data-season="monsoon">
                <h3>Monsoon (July - September)</h3>
                <p>Perfect for:</p>
                <ul>
                    <li>Wellness retreats</li>
                    <li>City exploration</li>
                    <li>Cultural experiences</li>
                </ul>
                <p>Temperature: 15°C - 25°C</p>
            </div>
            <div class="season-card" data-season="autumn">
                <h3>Autumn (October - November)</h3>
                <p>Perfect for:</p>
                <ul>
                    <li>Photography tours</li>
                    <li>Temple visits</li>
                    <li>Nature walks</li>
                </ul>
                <p>Temperature: 10°C - 20°C</p>
            </div>
            <div class="season-card" data-season="winter">
                <h3>Winter (December - February)</h3>
                <p>Perfect for:</p>
                <ul>
                    <li>Skiing in Auli</li>
                    <li>Snow viewing</li>
                    <li>Hot spring visits</li>
                </ul>
                <p>Temperature: -5°C - 10°C</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('searchForm');
    const loading = document.getElementById('loading');
    const introText = document.getElementById('introText');
    const destinationsGrid = document.getElementById('destinationsGrid');

    function cleanText(text) {
        return text.replace(/\*/g, '')                    // Remove asterisks
                  .replace(/^\d+\.\s*/, '')              // Remove leading numbers
                  .replace(/^Name of the destination:\s*/i, '')  // Remove "Name of the destination:" prefix
                  .replace(/^Name:\s*/i, '')             // Remove "Name:" prefix
                  .trim();
    }

    function extractIntroAndDestinations(data) {
        if (!Array.isArray(data.destinations) || data.destinations.length === 0) {
            return { intro: '', destinations: [] };
        }

        return {
            intro: '',
            destinations: data.destinations.map(dest => ({
                title: cleanText(dest.title),
                description: cleanText(dest.description)
            }))
        };
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        loading.style.display = 'block';
        introText.style.display = 'none';
        destinationsGrid.innerHTML = '';

        const formData = new FormData(this);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            loading.style.display = 'none';
            
            if (data.error) {
                destinationsGrid.innerHTML = `
                    <div class="destination-content">
                        <p style="color: #dc3545;">${data.error}</p>
                    </div>`;
            } else {
                const { destinations } = extractIntroAndDestinations(data);
                destinationsGrid.innerHTML = destinations.map(dest => `
                    <div class="destination-content">
                        <h3 class="destination-title">${dest.title}</h3>
                        <p class="destination-desc">${dest.description}</p>
                    </div>
                `).join('');
            }
        })
        .catch(error => {
            loading.style.display = 'none';
            destinationsGrid.innerHTML = `
                <div class="destination-content">
                    <p style="color: #dc3545;">An error occurred while fetching results. Please try again.</p>
                </div>`;
            console.error('Error:', error);
        });
    });

    // Season tabs functionality
    const seasonTabs = document.querySelectorAll('.season-tab');
    const seasonCards = document.querySelectorAll('.season-card');

    seasonTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const season = tab.dataset.season;
            seasonTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            seasonCards.forEach(card => {
                card.classList.toggle('active', card.dataset.season === season);
            });
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
