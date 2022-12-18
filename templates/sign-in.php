<main>
  <nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($categories as $category): ?>
        <li class="nav__item">
          <a href="pages/all-lots.html"><?= htmlspecialchars($category['name_category']); ?></a>
        </li>
      <?php endforeach; ?>
  </nav>
  <form class="form container <?= isset($errors) ? 'form--invalid' : "" ?>" action="../sign-in.php" method="post">
    <h2>Вход</h2>
    <div class="form__item <?= isset($errors["email"]) ? "form__item--invalid" : ""; ?>"> <!-- form__item--invalid -->
      <label for="email">E-mail <sup>*</sup></label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $user["email"] ?? "" ?>">
      <span class="form__error"><?= $errors["email"] ?? " " ?></span>
    </div>
    <div class="form__item form__item--last <?= isset($errors["password"]) ? "form__item--invalid" : ""; ?>">
      <label for="password">Пароль <sup>*</sup></label>
      <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= $user["password"] ?? "" ?>">
      <span class="form__error"><?= $errors["password"] ?? " " ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>
</main>
