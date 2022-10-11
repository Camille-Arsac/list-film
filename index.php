<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Liste de Films</title>
</head>
<body>
    <div>
        <?php
        require_once "pdo.php";
        $pagination = $_GET['pagination'] ?? 0;
        $limit = $_GET['limit'] ?? 10;
        $columnOrderBy = $_GET['column_order_by'] ?? 'title asc';
        $recipes = pdo($pagination, $limit, $columnOrderBy);
        ?>
        <form action="" method="get" id="films">
            <div id="sticky">
                <h1><a href="/">Liste de Films</a></h1>
                <div>
                    <p>Nombre de résultat par page
                        <input type="number" id="input" name="limit" required size="5" value="<?= $recipes['limit'] ?>">
                        <input type="submit" id="input-limit" value="Appliquer">
                    </p>

                    <p>Page
                        <select name="pagination" id="input" form="films">
                            <option value="<?= $recipes['pagination'] ?>"><?= $recipes['pagination']+1 ?></option>
                            <?php for ($i = 1 ; $i <= $recipes['final_page'] ; $i++) { ?>
                                <?php if ($i !== $recipes['pagination']+1) { ?>
                                    <option value="<?= $i - 1 ?>"><?= $i ?></option>
                            <?php }} ?>
                        </select>
                        <input type="submit" id="input-limit" value="Appliquer">
                    </p>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <input type="hidden" name="column_order_by" value="<?= $recipes['column_order_by'] ?>">
                        <?php if ($recipes['column_order_by'] == 'title asc') { ?>
                            <th>Titre du film <button type="submit" name="column_order_by" value="title desc">↓</button></th>
                        <?php } else if ($recipes['column_order_by'] == 'title desc') { ?>
                            <th>Titre du film <button type="submit" name="column_order_by" value="title asc">↑</button></th>
                        <?php } else { ?>
                            <th>Titre du film <button type="submit" name="column_order_by" value="title asc">↕</button></th>
                        <?php } ?>
                        <?php if ($recipes['column_order_by'] == 'rental_rate asc') { ?>
                            <th>Prix de location <button type="submit" name="column_order_by" value="rental_rate desc">↓</button></th>
                        <?php } else if ($recipes['column_order_by'] == 'rental_rate desc') { ?>
                            <th>Prix de location <button type="submit" name="column_order_by" value="rental_rate asc">↑</button></th>
                        <?php } else { ?>
                            <th>Prix de location <button type="submit" name="column_order_by" value="rental_rate asc">↕</button></th>
                        <?php } ?>
                        <th>Classement</th>
                        <?php if ($recipes['column_order_by'] == 'category_name asc') { ?>
                            <th>Genre <button type="submit" name="column_order_by" value="category_name desc">↓</button></th>
                        <?php } else if ($recipes['column_order_by'] == 'category_name desc') { ?>
                            <th>Genre <button type="submit" name="column_order_by" value="category_name asc">↑</button></th>
                        <?php } else { ?>
                            <th>Genre <button type="submit" name="column_order_by" value="category_name asc">↕</button></th>
                        <?php } ?>
                        <?php if ($recipes['column_order_by'] == 'rental_count asc') { ?>
                            <th>Nombre de location <button type="submit" name="column_order_by" value="rental_count desc">↓</button></th>
                        <?php } else if ($recipes['column_order_by'] == 'rental_count desc') { ?>
                            <th>Nombre de location <button type="submit" name="column_order_by" value="rental_count asc">↑</button></th>
                        <?php } else { ?>
                            <th>Nombre de location <button type="submit" name="column_order_by" value="rental_count asc">↕</button></th>
                        <?php } ?>
                    </tr>
                </thead>
                <?php foreach ($recipes['result'] as $recipe){?>
                     <tr>
                         <td>
                            <?= $recipe['title'] ?>
                         </td>
                         <td>
                             $<?= $recipe['rental_rate'] ?>
                         </td>
                         <td>
                             <?= $recipe['rating'] ?>
                         </td>
                         <td>
                             <?= $recipe['category_name'] ?>
                         </td>
                         <td>
                             <?= $recipe['rental_count'] ?>
                         </td>
                    </tr>
                <?php } ?>
            </table>

            <div id="div-pagination">
                <p id="pagination">
                    <?php if ($recipes['pagination'] > 0) { ?>
                        <button type="submit" id="input-pagination" name="pagination" value="<?= $recipes['pagination']-1 ?>">←</button>
                    <?php } ?>
                    page <?= $recipes['pagination']+1 ?> sur <?= $recipes['final_page'] ?>
                    <?php if ($recipes['pagination']+1 < $recipes['final_page']) { ?>
                        <button type="submit" id="input-pagination" name="pagination" value="<?= $recipes['pagination']+1 ?>">→</button>
                    <?php } ?>
                </p>
            </div>
        </form>
    </div>

    <footer>Camille ARSAC - MT5P2022 HETIC — Cours SGBDR - Kévin GLASS</footer>
</body>
</html>
