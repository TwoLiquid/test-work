
## Развертывание проекта

Достаточно сделать composer install для полной инициализации.

Миграции и сидинг делаются также стандартно в Laravel.

## Конфиги пользователя

Набор данных для data полльзователя определяется в конфигах. Там же массив hobbies и значения gender. Можно всегда расширить их в конфигах и добавить необходимое условие по новому параметру в функции поиска с фильтрами в UserRepository.

## Сидинг данных

Данные генерируются случайно. Имена генерирует Faker, набор всех возможных данных в data тоже случаен, при каждом новом сидинге будут генерироваться пользователи с разными наборами данных и именами.

## API

Для единственного GET запрос в апи не было смысла делать аутентификацию по токену, поэтому никакой специфический middleware не создавался. Пример запроса прилагается в POSTMAN коллекции
