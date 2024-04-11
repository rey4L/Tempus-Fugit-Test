<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=CSS_URL."main.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."menu-item-add.css"?>>
    <title>Menu Item Form</title>
</head>

<body>
    <form action="<?=BASE_URL."/MenuItem"?>"method="POST" id="menu-back-form"></form>
    <form class="menu-item-add-form" action="<?=BASE_URL."/MenuItem/create"?>" method="post">
        <p class="form-name-text">
            CREATE MENU ITEM
        </p>
        <label for="name">Name</label>
        <input type="text" name="name" required>

        <label for="tags">Tags <img class="info-icon" src="<?= RESOURCE_URL."info_icon.png"?>" alt="Info icon" title="No spaces, separated by commas(,)"></label>
        <input type="text" name="tags" required>

        <label for="price">Price</label>
        <input type="text" name="price" required>

        <label for="cost-to-produce">Cost to produce</label>
        <input type="text" name="cost-to-produce" required>

        <label for="description">Description</label>
        <input type="text" name="description" required>

        <label for="stock">Stock</label>
        <input type="text" name="stock" required>

        <label for="image">Image Url</label>
        <input type="text" name="image" required>

        <label for="discount">Discount <img class="info-icon" src="<?= RESOURCE_URL."info_icon.png"?>" alt="Info icon" title="Enter the discount percentage in decimal form (e.g. 0.5 for 50% off)"></label>
        <input type="text" name="discount" required>

        <label for="ingredients">Ingredients <img class="info-icon" src="<?= RESOURCE_URL."info_icon.png"?>" alt="Info icon" title="No spaces, separated by commas(,)"></label>
        <input type="text" name="ingredients" required>

        <button type="submit">Submit</button>
        <button type="submit" class="menu-back-button" form="menu-back-form">Back To List</button>
    </form>
</body>
</html>