## Questionnaire-test-CR

### Run Project

```
composer install
cp .env.example .env
./vendor/bin/sail up -d --build
docker exec -it questionnaire-app bash
php artisan migrate --seed
npm i
npm run dev
```

### Down Project

```
./vendor/bin/sail down
```

## Zadanie

### Zadanie polega na przygotowaniu frontu i backu mechanizmu ankiety składającej się z kilku pytań oraz listingu wypełnionych ankiet z udzielonymi odpowiedziami.

### Proszę w ankiecie umieścić 3 rodzaje pytań;

```
1. Pytanie z inputem textarea (np. Z jakich źródeł korzystasz tworząc paletę kolorów?)
2. Pytanie z inputem select (np. Wybierz swój ulubiony kolor: [czerwony, żółty, pomarańczowy, zielony, niebieski, fioletowy])
3. Pytanie składające się z kilku podpytań polegające na ocenieniu w skali 1-5 kilku składowych.
        np. oceń każdy kolor z pytania 2. w skali 1-5
```

### Założenia:

```
W danej chwili wypełniający ankietę widzi tylko jedno pytanie.
Odpowiedź na każde pytanie jest wymagana, żeby przejść do następnego.
Można wrócić do poprzedniego pytania i zmienić odpowiedź.
```
