<?php
/** @var EditPresenter $presenter */
[$presenter, $template] = $GLOBALS['presenter'];
$post = isset($template->post) ? (object)$template->post : null;

$categoryId = $_POST['category'] ?? $post?->category_id ?? '';
$text = $_POST['text'] ?? $post?->text ?? '';
?>

<form method="post">
    <div class="form-group">
        <label for="category">Kategorie:</label>
        <select name="category" id="category" required
                class="form-control <?= !empty($template->errors['category']) ? 'is-invalid' : '' ?>">
            <option value="">--vyberte--</option>
            <?php foreach ($template->categories as $category): ?>
                <option value="<?= $category['category_id'] ?>"
                    <?= (isset($post?->category_id) && $category['category_id'] == $categoryId) ? 'selected="selected"' : '' ?>
                >
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($template->errors['category'])): ?>
            <div class="invalid-feedback"><?= $template->errors['category'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="text">Text příspěvku:</label>
        <textarea name="text" id="text" required
                  class="form-control <?= !empty($template->errors['text']) ? 'is-invalid' : '' ?>"><?= htmlspecialchars($text) ?></textarea>
        <?php if (!empty($template->errors['text'])): ?>
            <div class="invalid-feedback"><?= $template->errors['text'] ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">uložit...</button>
    <a href="index.php" class="btn btn-light">zrušit</a>
</form>