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
  <section class="lot-item container">
    <h2><?= $lot['name']; ?></h2>
    <div class="lot-item__content">
      <div class="lot-item__left">
        <div class="lot-item__image">
          <img src="uploads/<?= $lot['image']; ?>" width="730" height="548" alt="<?= $lot['name']; ?>">
        </div>
        <p class="lot-item__category">Категория: <span><?= $lot['category'] ?></span></p>
        <p class="lot-item__description"><?= $lot['description']; ?></p>
      </div>
      <div class="lot-item__right">
        <?php if (isset($_SESSION["user"])): ?>
          <div class="lot-item__state">
          <?php $res_date = get_time_left(htmlspecialchars($lot['expiration'])) ?>
          <div class="lot__timer timer <?= $res_date[0] <   1 ? 'timer--finishing' : ''; ?>">
            <?= "$res_date[0] : $res_date[1]";?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?= get_formatted_price($lot["price"]) ?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка <span><?= get_formatted_price($min_bet); ?></span>
            </div>
          </div>
          <form class="lot-item__form" action="../lot.php?id=<?= $lot["id"] ?>" method="post" autocomplete="off">
            <p class="lot-item__form-item form__item <?= isset($errors["cost"]) ? "form__item--invalid" : ""; ?>">
              <label for="cost">Ваша ставка</label>
              <input id="cost" type="text" name="cost" value="<?= $cost ?? "" ?>" placeholder="<?= $min_bet; ?>">
              <span class="form__error"><?= $errors["cost"]; ?></span>
            </p>
            <button type="submit" class="button">Сделать ставку</button>
          </form>
        </div>
        <?php endif; ?>
        <div class="history">
          <h3>История ставок (<span>10</span>)</h3>
          <table class="history__list">
            <tr class="history__item">
              <td class="history__name">Иван</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">5 минут назад</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Константин</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">20 минут назад</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Евгений</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">Час назад</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Игорь</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 08:21</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Енакентий</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 13:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Семён</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 12:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Илья</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 10:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Енакентий</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 13:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Семён</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 12:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Илья</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 10:20</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>
