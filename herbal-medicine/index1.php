<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="homepage.css">
    <script src="https://kit.fontawesome.com/a556fe87b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="./photo/ee.png" alt="logo">
            </div>
            <ul>
                <li><a href="About1.html">About Us!</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item">
                <img class="cell" src="./photo/ll2.jpg" alt="">
                <div class="carousel-caption">
                    <b><h1 >Welcome to</h1></b>
                    <h1>Wonderscape</h1>    
                </div>
            </div> 
            <div class="carousel-item">
                <img class="cell" src="./photo/mm2.jpg" alt="g1">
            </div>
        </div>
    </div>
    <div class="search-container">
        <form method="post" action="">
            <div class="search-field">
                <i class="fas fa-search"></i>
                <input type="text" name="search_query" placeholder="Search...">
                <button type="submit" class="submit-button">Submit</button>
            </div>
        </form>
    </div>
    <div class="output-box" id="output">
        <?php
            $apiEndpoint = 'https://api.fda.gov/drug/label.json';

            $commonMedicines = [
                'paracetamol' => [
                    'dosage_and_administration' => ' Paracetamol is a commonly used medicine that can help treat pain and reduce a high temperature fever. It is typically used to relieve mild or moderate pain, such as headaches, toothache, or sprains, and reduce fevers caused by illnesses such as colds and flu.',
                    'Indications and Usage' => 'Paracetamol is a medicine used to treat mild to moderate pain. Paracetamol can also be used to treat fever (high temperature). It is dangerous to take more than the recommended dose of paracetamol.',
                ],
            ];

            $searchQuery = '';
            $searchResults = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                $searchQuery = strtolower($_POST['search_query']);

                if (isset($commonMedicines[$searchQuery])) {
                    $result = $commonMedicines[$searchQuery];
                    displayMedicineInformation($result);
                } else {        
                    $queryParameters = [
                        'limit' => 1,
                        'search' => $searchQuery,
                    ];
                    $apiUrl = $apiEndpoint . '?' . http_build_query($queryParameters);
                    $response = file_get_contents($apiUrl);  
                    if ($response !== false) {          
                        $searchResults = json_decode($response, true);

                        if ($searchResults === null && json_last_error() !== JSON_ERROR_NONE) {
                            die('Error decoding OpenFDA JSON data: ' . json_last_error_msg());
                        }
                    } else {
                        die('Error accessing OpenFDA API');
                    }
                    if (!empty($searchResults['results'])) {
                        echo '<div class="search-results">';
                        echo '<h3>Search Results:</h3>';
                        
                        foreach ($searchResults['results'] as $result) {
                            echo '<div class="result-box">';
                            displayMedicineInformation($result);
                            echo '</div>';
                            echo '<br>';
                        }

                        echo '</div>';
                    } else {
                        echo '<p>No results found for the given search query.</p>';
                    }
                }
            }

            function displayMedicineInformation($result) {
                echo '<div class="search-results">';
                echo '<h3>Medicine Information:</h3>';
                echo '<strong>Indications and Usage:</strong> ' . $result['indications_and_usage'][0] . '<br>';

                if (isset($result['warnings'])) {
                    echo '<strong>Warnings:</strong> ' . (is_array($result['warnings']) ? implode(", ", $result['warnings']) : $result['warnings']) . '<br>';
                } else {
                    echo '<strong>Warnings:</strong> N/A<br>';
                }

                $additionalFields = [
                    'keep_out_of_reach_of_children',
                    'dosage_and_administration',
                    'storage_and_handling',
                    'package_label_principal_display_panel'
                ];
                foreach ($additionalFields as $field) {
                    echo '<strong>' . ucwords(str_replace('_', ' ', $field)) . ':</strong> ' . ($result[$field][0] ?? 'N/A') . '<br>';
                }
                echo '</div>';
            }
        ?>
        
    </div>

    <div id="catagories">
    <div class="container">
        <h1 class="sub-title"><b>Categories</b></h1>
        <div class="catagories-list">
            <div class="catagory">
                <!-- <img src="catagory0.jpg" alt=""> -->
                <a href="mmm.php">
                <img src="catagory0.jpg" alt="">
                </a>
                <div class="layer">
                    <h3><b>Packed Products</b></h3>
                    <p>Information related to ingridients used in products</p>
                </div>
            </div>
            <div class="catagory">
                <img src="catagory1.jpeg" alt="">
                <div class="layer">
                    <h3><b>Medicine</b></h3>
                    <p>Information of medicines</p>
                </div>
            </div>
            <div class="catagory">
                <img src="catagory2.jpeg" alt="">
                <div class="layer">
                    <h3><b>Technology</b></h3>
                    <p>Information related to different versions of component</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- -----------------------------------------------------------Contact-->
<div id="contact">
    <div class="container">
        <div class="row">
            .contact-left
        </div>
    </div>
</div>


   

    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script>
        $(document).ready(function() {
    $('.carousel-inner').flickity({
        cellAlign: 'left',
        wrapAround: true,
        freeScroll: true
    });
    let currentIndex = 0;
    const items = document.querySelectorAll('.carousel-item');
    function showItem(index) {
        if (index < 0 || index >= items.length) {
            return;
        }
        currentIndex = index;
        const translateValue = -index * 100 + '%';
        document.querySelector('.carousel-inner').style.transform = 'translateX(' + translateValue + ')';
    }
    setInterval(() => {
        currentIndex = (currentIndex + 1) % items.length;
        showItem(currentIndex);
    }, 3000);
});
</script>
</body>
</html>
