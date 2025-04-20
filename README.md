# Project Description

The project based-on some business use-case from a distributor for seeds and fertilizers company. We covered three main cases, they are manage stocks on multi warehouses (isolated), to track sales canvasses activity and syncronize moving-stock accross warehouses.

# ERD Diagram

![Erd Diagram](/erd.png)

# Problem and Solutions

What are the problems and what we proposed,

1. The old excel-based workflows is messy, not because the excel, but how they using the excel. The excel they created is unstandarized, admin-oriented and hard to understand in first place (not just one warehouse). It also just stored in one laptop, no backup, when it crashed it's gone. So, we optimize this process with web-based management system.
2. The canvasses activity takes 5-7 days to return back and report the sales to the offices. This is a problem, when the purchasing division trying to re-order the stocks, they should know what stocks is sold as soon as possible. They are already has a strategy for this, but we proposed other options to make the sales staf record the sales as soon as possible.
3. The moving-stocks between warehouses. When stocks moving from a warehouse to another, it takes 3-4 days (administration, distance, etc) to receive the confirmation. Again, sometimes, the purchasing needs to order new stocks. And we proposed to a single click button to syncronize the stocks on sender and receiver warehouse.
4. The management needs to know a real-time stocks report whenever, not need to wait the staf to create it first.

# Tech Stuff

## Tech Stack

The tech stack we used in this projects are,

1. PHP 8.2
2. Laravel framework (11.9)
3. TailwindCSS v3
4. AlpineJS
5. DomPDF

## Install

To install just follow this command on you terminal,

```bash
git clone https://github.com/azharisikumbang/cvwpm.git
cd cvwpm

composer install
# dont forget to setting database config at .env file
```

Run the migrations to supply administrator data and some fake data, (run one of the command)

```bash
php artisan migrate --seed # for all data
php artisan migrate --seeder=AdminAndManajerUserSeeder # if you just want admin and manager user, not all fake data
```

Just build the front-end,

```bash
npm install
npm run build
```

Run the project,

```bash
php artisan serve
```

# Give a try

```txt
Account list
All username just use password = 12345678

Available username:
- admin (Web Admin)
- manager (Manager)

- stockpadang (Admin Stok Padang)
- purchasingpadang (Admin Purchasing Padang)
- salespadang (Sales Padang)

- stocksolok (Admin Stok solok)
- purchasingsolok (Admin Purchasing solok)
- salessolok (Sales solok)
```
