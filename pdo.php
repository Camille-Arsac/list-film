<?php
function pdo($pagination = 0, $limit = 10, $columnOrderBy = "title asc"){
    try
    {
        $db = new PDO('mysql:host=mysql:3306;dbname=sakila;charset=utf8', 'user', 'password');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    $offset = $pagination * $limit;

    $sqlQuery = "
    SELECT title, rental_rate, rating, category.name AS category_name, count(rental.customer_id) AS rental_count
    FROM film
    INNER JOIN film_category 
        ON film.film_id = film_category.film_id
    INNER JOIN category 
        ON category.category_id = film_category.category_id
    LEFT JOIN inventory
        ON inventory.film_id = film.film_id
    LEFT JOIN  rental
        ON rental.inventory_id = inventory.inventory_id
    GROUP BY title
    ORDER BY $columnOrderBy
    LIMIT $limit
    OFFSET $offset;";

    $slqQuery2 = "
    SELECT CEIL(COUNT(*) / $limit)
    FROM film;";

    $recipesStatement = $db->prepare($sqlQuery);
    $recipesStatement2 = $db->prepare($slqQuery2);
    $recipesStatement->execute();
    $recipesStatement2->execute();

    return [
        'result' => $recipesStatement->fetchAll(),
        'pagination' => $pagination,
        'final_page' => $recipesStatement2->fetch(PDO::FETCH_COLUMN),
        'limit' => $limit,
        'column_order_by' => $columnOrderBy
    ];
}


