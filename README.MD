<br />
<div id="readme-top" align="center">
  <a href="https://github.com/itsmrval/subway">
    <img src="https://raw.githubusercontent.com/itsmrval/subway/main/public/assets/logo/dark.png" alt="Logo" width="164">
  </a>

  <h3 align="center">Subway Schedule</h3>

  <p align="center">
    A school project using php vanilla to provide user-saved real-time information on metro stations
    <br />
    <br />
    View Demo
    ·
    <a href="https://github.com/itsmrval/subway/issues">Report Bug</a>
    ·
    <a href="https://github.com/itsmrval/subway/pulls">Pull request</a>
  </p>
</div>


## What is Subway Schedule

<img src="https://i.imgur.com/ZjLkOIR.png" width="500px">

Note: This app is not intended for production use, but for personal or educational purposes.

### Built With

This section list major frameworks/libraries used

* ![](https://img.shields.io/badge/php-20232A?style=for-the-badge&logo=php)
* ![](https://img.shields.io/badge/MySQL-20232A?style=for-the-badge&logo=mysql)
* ![](https://img.shields.io/badge/Bootstrap-20232A?style=for-the-badge&logo=bootstrap)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



## Getting Started

Now let's see how to set up an subway schedule instance.
### Prerequisites

First, install nginx, php and mysql on your server.<br>
Then, create a user with a database 


### Installation

1. Clone the repository
   ```sh
   cd /my/directory
   git clone https://github.com/itsmrval/subway .
   ```
2. Copy the example config
   ```sh
   cp config_example.php config.php
   ```
3. Change `config.php` permissions
   ```sh
   chmod 600 config.php
   ```
4. Copy and rename `exemple.env`
   ```js
   cp exemple.env .env
   ```
 5. Complete `config.php`
	* idfm_api_key with your [IDFM PRIM account](https://prim.iledefrance-mobilites.fr)
	* db_host / db_user / db_password / db_name with mysql infos.
	
6. Run your nginx server on `/public` directory
  
<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Known issues 

- Some stations with RER A doesnt display timetables


## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>
