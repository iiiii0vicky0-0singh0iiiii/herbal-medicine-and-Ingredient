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
                <li><a href="#">About Us!</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item">
                <img class="cell" src="./photo/ll2.jpg" alt="">
                <div class="carousel-caption">
                    <h1>Welcome to</h1>
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
        $ingredientsJson = 'project.json'; 
        $searchQuery = '';
        $searchResults = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchQuery = strtolower($_POST['search_query']);

            
            $ingredients = json_decode(file_get_contents($ingredientsJson), true);

            if ($ingredients === null && json_last_error() !== JSON_ERROR_NONE) {
                die('Error decoding JSON data: ' . json_last_error_msg());
            }

            foreach ($ingredients['ingredients'] as $ingredient) {
                
                if (stripos($ingredient['name'], $searchQuery) !== false) {
                    $searchResults[] = $ingredient;
                }
            }
        }

        if (!empty($searchResults)) {
            echo '<div class="search-results">';
            echo '<h3>Search Results:</h3>';

            foreach ($searchResults as $result) {
                echo '<div class="result-box">';
                echo '<h4>' . $result['name'] . '</h4>';
                echo '<p><strong>Description:</strong> ' . $result['description'] . '</p>';
                echo '<p><strong>Advantages:</strong> ' . $result['advantages'] . '</p>';
                echo '<p><strong>Disadvantages:</strong> ' . $result['disadvantages'] . '</p>';
                echo '<p><strong>side_effects:</strong> ' . $result['side_effects'] . '</p>';
                echo '</div>';
                echo '<br>';
            }

            echo '</div>';
        } else {
            echo '<p>No results found for the given search query.</p>';
        }
        ?>
    </div>

    <div id="catagories">
        <div class="container">
            <h1 class="sub-title"><b>Categories</b></h1>
            <div class="catagories-list">
                <div class="catagory">
                    <img src="catagory0.jpg" alt="">
                    <div class="layer">
                        <h3><b>Packed Products</b></h3>
                        <p>Information related to ingredients used in products</p>
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
                        <p>Information related to different versions of components</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script>
        $(document).ready(function () {
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
