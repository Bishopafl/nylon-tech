## About The Project

Utilizing Laravel within a docker container, I am going to be setting up a single route that takes some parameters and saves them to the database. 

## To get this project started

My local machine is a Mac M1 machine, and might have a different  setup than your machine. To adjust for this if you do not have a MAC with M1 chip, remove :19 within the docker-compose.yml file. this references the linux/amd64 specifically to run locally on my machine. if you are able to clone and run the container as expected, please skip this step.

## Prerequisites
- Docker installed on your machine
- Docker Compose installed on your machine

## Getting Started
1. Clone the repository:

`git clone https://github.com/Bishopafl/nylon-tech.git`

2. Navigate to the project directory:

`cd nylon-tech`

3. Build and start the Docker containers:

`docker-compose up -d --build`

## Troubleshooting
If you encounter any issues, please ensure that you have followed the prerequisites and steps correctly. If the problem persists, ensure that you are using the correct machine. If not adjust the docker-compose.yml file according to your machine setup.

### Additional Information
The Docker Compose configuration is optimized for a Mac M1 machine. If you are using a different machine, you might need to adjust the docker-compose.yml file accordingly.

The Laravel application is set up to use MySQL as the database. The database credentials are defined in the app service's environment variables in the docker-compose.yml file.

The Dockerfile is set up to install the necessary dependencies, copy the application code, install Composer dependencies, and expose port 8000 for the application.

The project uses a non-root user within the container to run the application.

Health checks are added to the Dockerfile to ensure that the application is running correctly.

## License
This project is open-sourced under the MIT license.