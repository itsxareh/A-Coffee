<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, price, category, ingredients, description, image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $ingredientsArray = explode(", ", $data['ingredients']);

    $formattedIngredients = "<ul>";
    foreach ($ingredientsArray as $ingredient) {
        $formattedIngredients .=    "<li class='relative pl-3'><span class='absolute left-0 top-0 h-full flex items-center'>•</span>
                                        <p class=''>$ingredient</p>
                                    </li>";
    }
    $formattedIngredients .= "</ul>";

    $data['ingredients'] = $formattedIngredients;

    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'ID parameter is missing'));
}
?>
