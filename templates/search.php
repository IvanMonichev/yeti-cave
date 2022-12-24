<main>
  <nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($categories as $category): ?>
        <li class="nav__item">
          <a href="pages/all-lots.html"><?= htmlspecialchars($category['name_category']); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <div class="container">
    <section class="lots">
      <?php if ($query): ?>
        <h2>Результаты поиска по запросу «<span><?= $query; ?></span>»</h2>
      <?php else: ?>
        <h2>Запрос поиска пуст</h2>
      <?php endif; ?>

      <?php if (empty($goods)): ?>
        <p>Ничего не найдено по вашему запросу</p>
      <?php else: ?>
        <ul class="lots__list">
        <?php foreach ($goods as $good): ?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="uploads/<?= htmlspecialchars($good["image"]) ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= htmlspecialchars($good["category"]) ?></span>
              <h3 class="lot__title"><a class="text-link" href="<?= '/lot.php?id=' . $good['id'] ?>"><?= htmlspecialchars($good["name"]) ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?= get_formatted_price($good["price"]) ?></span>
                </div>
                <?php $res_date = get_time_left(htmlspecialchars($good["expiration"])) ?>
                <div class="lot__timer timer <?= $res_date[0] <   1 ? 'timer--finishing' : ''; ?>">
                  <?= "$res_date[0] : $res_date[1]";?>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </section>
    <?php if($page_count > 1): ?>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev">
          <a href="search.php?search=<?= $query; ?><?= $current_page > 1 ? "&page=" . $current_page - 1 : ""?>">Назад</a>
        </li>
        <?php foreach ($pages as $page): ?>
          <li class="pagination-item <?= $current_page === $page ? "pagination-item-active" : "" ?>">
            <a href="search.php?search=<?= $query; ?>&page=<?= $page; ?>"><?= $page; ?></a>
          </li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next">
          <a href="search.php?search=<?= $query; ?>&page=<?= $current_page < $page_count ? $current_page + 1 : $page_count?>">Вперед</a>
        </li>
      </ul>
    <?php endif; ?>
  </div>
</main>
