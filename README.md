<a name="readme-top"></a>

<!-- PROJECT SHIELDS -->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/Nate-go/school-verse">
    <img src="logo-school-verse.png" alt="Logo" width="300" height="91">
  </a>

  <h3 align="center">school-verse</h3>

  <p align="center">
    This README find for the school-verse project!!
    <br />
    <a href="https://github.com/Nate-go/school-verse"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/Nate-go/school-verse">View Demo</a>
    ·
    <a href="https://github.com/Nate-go/school-verse/issues">Report Bug</a>
    ·
    <a href="https://github.com/Nate-go/school-verse/issues">Request Feature</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
        <li><a href="#project-structure">Project Structure</a></li>
        <li><a href="#architecture-diagram">Architecture Diagram</a></li>
        <li><a href="#database-diagram">Database Diagram</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

![Screenshot (1107)](https://github.com/Nate-go/school-verse/assets/140036945/c6eba647-e99b-4278-ae83-a22fec9caa96)

School-Verse is an advanced school management system designed to streamline and enhance administrative tasks within educational institutions. Our comprehensive platform is tailored to meet the unique needs of schools, enabling them to efficiently manage various aspects of their daily operations.

With School-Verse, administrators can effortlessly handle student enrollment, attendance tracking, and academic records. The platform simplifies the scheduling of classes and exams, making it easier for schools to organize their academic calendar. It also offers a centralized database for storing and accessing student and staff information securely.

Additionally, School-Verse empowers teachers with tools to manage their classrooms effectively. They can easily record and evaluate student grades, create interactive lesson plans, and communicate with students and parents within the platform.

Our goal is to provide schools with a user-friendly, reliable, and comprehensive management solution, freeing up valuable time for educators and administrators to focus on what truly matters: nurturing the growth and development of students. With School-Verse, educational institutions can embrace digital transformation and create a more efficient, connected, and thriving learning community.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Built With

This section should list any major frameworks/libraries used to bootstrap your project. Leave any add-ons/plugins for the acknowledgements section. Here are a few examples.

* [![Laravel][Laravel.com]][Laravel-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![JQuery][JQuery.com]][JQuery-url]
* [![MySQL][MySQL.com]][MySQL-url]
* [![Blade][Blade.com]][Blade-url]
* [![Tailwind][Tailwind.com]][Tailwind-url]
* [![Livewire][Livewire.com]][Livewire-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Project structure
```
.
├───app
│   ├───Console
│   │   └───Commands
│   ├───Constant
│   ├───Events
│   ├───Exceptions
│   ├───Http
│   │   ├───Controllers
│   │   ├───Livewire
│   │   │   ├───Detail
│   │   │   ├───Fregment
│   │   │   ├───Initialization
│   │   │   ├───Table
│   │   │   └───Ulti
│   │   ├───Middleware
│   │   └───Resources
│   ├───Jobs
│   ├───Mail
│   ├───Models
│   ├───Providers
│   ├───Services
│   │   └───ModelServices
│   └───Traits
│       ├───Model
│       └───ServiceInjection
├───bootstrap
│   └───cache
├───config
├───database
│   ├───factories
│   ├───migrations
│   └───seeders
├───public
│   ├───build
│   │   └───assets
│   ├───css
│   ├───img
│   ├───js
│   └───storage
├───resources
│   ├───css
│   ├───img
│   ├───js
│   └───views
│       ├───admin
│       │   ├───grade
│       │   ├───insistence
│       │   ├───room
│       │   ├───school-year
│       │   ├───student
│       │   ├───subject
│       │   ├───teacher
│       │   └───user
│       ├───emails
│       ├───error
│       ├───livewire
│       │   ├───detail
│       │   ├───fregment
│       │   ├───initialization
│       │   ├───table
│       │   └───ulti
│       ├───student
│       │   └───room
│       ├───teacher
│       │   ├───exam
│       │   ├───insistences
│       │   └───room
│       ├───user
│       └───vendor
│           └───livewire-ui-modal
├───routes
├───scripts
├───storage
│   ├───app
│   │   ├───livewire-tmp
│   │   └───public
│   │       └───images
│   ├───framework
│   │   ├───cache
│   │   │   └───data
│   │   │       ├───76
│   │   │       │   └───e7
│   │   │       ├───9c
│   │   │       │   └───1c
│   │   │       └───ee
│   │   │           └───2f
│   │   ├───sessions
│   │   ├───testing
│   │   └───views
│   └───logs
├───tests
│   ├───Feature
│   └───Unit
│       └───Services
│           └───ModelServices
│               ├───ExamServiceTest
│               ├───GradeServiceTest
│               ├───InsistenceServiceTest
│               ├───RoomServiceTest
│               ├───SchoolYearServiceTest
│               ├───StudentServiceTest
│               ├───SubjectServiceTest
│               ├───TeacherServiceTest
│               └───UserServiceTest
└───xdebug
    ├───.azure
    │   ├───i386
    │   └───macos
    ├───.build.scripts
    ├───.circleci
    ├───.github
    │   └───workflows
    ├───.xdebugci
    ├───contrib
    ├───m4
    ├───src
    │   ├───base
    │   ├───coverage
    │   ├───debugger
    │   ├───develop
    │   ├───gcstats
    │   ├───lib
    │   ├───profiler
    │   └───tracing
    └───tests
        ├───base
        ├───coverage
        ├───debugger
        │   └───dbgp
        ├───develop
        ├───filter
        │   ├───foobar
        │   ├───stack
        │   └───xdebug
        │       └───trace
        ├───gcstats
        ├───library
        ├───profiler
        └───tracing
```
<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Architecture diagram

![architecture-diagram drawio](https://github.com/Nate-go/school-verse/assets/140036945/45d869ae-5074-4f2b-9c36-8734e24d42bc)


<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Database diagram

![mermaid-diagram-school-verse](https://github.com/Nate-go/school-verse/assets/140036945/9fc41eec-d075-47a3-b26f-93337e5ed31d)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- GETTING STARTED -->
## Getting Started

Follow these steps to clone and run the Laravel project school-verse on your local machine:

### Prerequisites

1. PHP: You'll need PHP version 10. or higher installed on your machine. You can check your PHP version by running php -v in the command line.

2. Composer: Composer is a PHP package manager that is required for Laravel. You can download and install it from the official website: https://getcomposer.org/download/

3. MySQL: Ensure you have a MySQL database server set up or any other database supported by Laravel.

### Installation

_Below is an example of how you can instruct your audience on installing and setting up your app. This template doesn't rely on any external dependencies or services._

1. Clone the repository:
   ```sh
   git clone https://github.com/Nate-go/school-verse.git
   ```
2. Navigate to the project directory:
   ```sh
   cd school-verse
   ```
3. Install project dependencies:
   ```sh
   composer install
   ```
4. Create a copy of the `.env.example` file and rename it to `.env`:
   ```sh
   cp .env.example .env
   ```
5. Generate the application key:
   ```sh
   php artisan key:generate
   ```
6. Configure the database:
    * Open the `.env` file in a text editor.
    * Set the database connection details like `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` according to your MySQL setup.
7. Import:
   ```sh
   composer require jantinnerezo/livewire-alert
   composer require wire-elements/modal
   ```
8. Run the database migrations and seed:
   ```sh
   php artisan migrate --seed
   ```
9. Serve the application and active queue:
   ```sh
   php artisan queue:work
   php artisan serve
   ```
10. Open your web browser and navigate to http://localhost:8000 to see the application running.
   
Congratulations! You have successfully cloned, installed, and run the Laravel project on your local machine. Now you can start exploring and customizing it for your needs. If you encounter any issues, feel free to open an issue on the project's repository or seek help from the Laravel community. Goodluck!
   

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

This website will help you to manage the school issue
- For admin role
![Screenshot (1108)](https://github.com/Nate-go/school-verse/assets/140036945/9179d3e8-c696-4a8e-adee-a2f82adac88b)

- For teacher role
![Screenshot (1109)](https://github.com/Nate-go/school-verse/assets/140036945/130b2c9a-bf34-4b5f-935f-4becfc5db041)

- For student role
![Screenshot (1110)](https://github.com/Nate-go/school-verse/assets/140036945/08d2c0a5-1684-4cbb-ad74-0ec2c976a02b)

_For more examples, please refer to the [Documentation](https://example.com)_

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

- [x] Add Changelog
- [x] Add back to top links
- [ ] Add Additional Templates w/ Examples
- [ ] Add "components" document to easily copy & paste sections of the readme
- [ ] Multi-language Support
    - [ ] Chinese
    - [ ] Spanish

See the [open issues](https://github.com/Nate-go/school-verse/issues) for a full list of proposed features (and known issues).

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

Nate - nate.ha.goldenowl@egmail.com

Project Link: [https://github.com/Nate-go/school-verse](https://github.com/Nate-go/school-verse)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

Use this space to list resources you find helpful and would like to give credit to. I've included a few of my favorites to kick things off!

* [Choose an Open Source License](https://choosealicense.com)
* [GitHub Emoji Cheat Sheet](https://www.webpagefx.com/tools/emoji-cheat-sheet)
* [Malven's Flexbox Cheatsheet](https://flexbox.malven.co/)
* [Malven's Grid Cheatsheet](https://grid.malven.co/)
* [Img Shields](https://shields.io)
* [GitHub Pages](https://pages.github.com)
* [Font Awesome](https://fontawesome.com)
* [React Icons](https://react-icons.github.io/react-icons/search)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/Nate-go/school-verse.svg?style=for-the-badge
[contributors-url]: https://github.com/Nate-go/school-verse/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/Nate-go/school-verse.svg?style=for-the-badge
[forks-url]: https://github.com/Nate-go/school-verse/network/members
[stars-shield]: https://img.shields.io/github/stars/Nate-go/school-verse.svg?style=for-the-badge
[stars-url]: https://github.com/Nate-go/school-verse/stargazers
[issues-shield]: https://img.shields.io/github/issues/Nate-go/school-verse.svg?style=for-the-badge
[issues-url]: https://github.com/Nate-go/school-verse/issues
[license-shield]: https://img.shields.io/github/license/Nate-go/school-verse.svg?style=for-the-badge
[license-url]: https://github.com/Nate-go/school-verse/blob/master/LICENSE.txt
[product-screenshot]: images/screenshot.png
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com 
[MySQL.com]: https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white
[MySQL-url]: https://www.mysql.com/
[Blade.com]: https://img.shields.io/badge/Blade-39464e?style=for-the-badge&logo=laravel&logoColor=white
[Blade-url]: https://laravel.com/docs/10.x/blade
[Tailwind.com]: https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white
[Tailwind-url]: https://tailwindcss.com/
[Livewire.com]: https://img.shields.io/badge/Livewire-FF4E1F?style=for-the-badge&logo=laravel&logoColor=white
[Livewire-url]: https://laravel-livewire.com/
