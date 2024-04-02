<?php
/** @var HomepagePresenter $presenter */
[$presenter, $template] = $GLOBALS['presenter'];
?>

<?php $posts = $template->posts; ?>

<div class="row mb-10">
    <form method="get" class="row">
        <div class="col-8 form-group">
            <label for="category">Filter by Category:</label>
            <select name="categoryId" id="category" class="form-control">
                <option value="">--Vyberte--</option>
                <?php foreach ($template->categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"
                        <?= (isset($_GET['categoryId']) && $category['category_id'] == $_GET['categoryId']) ? 'selected="selected"' : '' ?>
                    >
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-4 form-group d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>
</div>
<?php if (!empty($posts)): ?>
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <article class="col-12 col-md-6 col-lg-4 col-xl-3 border border-dark mx-1 my-1 px-2 py-1">
                <div><span class="badge badge-secondary"><?= htmlspecialchars($post['category_name']) ?></span></div>
                <div><?= nl2br(htmlspecialchars($post['text'])) ?></div>
                <div class="small text-muted mt-1">
                    <?= htmlspecialchars($post['user_name']) ?>
                    <?= date('d.m.Y H:i:s', strtotime($post['updated'])) ?>
                </div>
                <div class="mt-2">
                    <a href="edit.php?postId=<?= $post['post_id'] ?>" class="btn btn-secondary">Edit</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php elseif (isset($template->categoryDoesNotExist)): ?>
    <div class="alert alert-info">Toto kategorie neexistuje.</div>
<?php else: ?>
    <div class="alert alert-info">Nebyly nalezeny žádné příspěvky.</div>
<?php endif; ?>

<div class="row my-3">
    <a href="edit.php" class="btn btn-primary">Přidat příspěvek</a>
</div>