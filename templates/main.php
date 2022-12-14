<main class="container">
  <section class="promo">

    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
      снаряжение.</p>
    <ul class="promo__list">
      <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--<?= $category['character_code']; ?>">
          <a class="promo__link" href="pages/all-lots.html"><?= $category['name_category'] ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>
  <section class="lots">
    <div class="lots__header">
      <h2>Открытые лоты</h2>
    </div>
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
  </section>
</main>