# Integration Test with External AdNetwork [PHP7]
This repository contains a solution to the task of connecting a service with an external AdNetwork using their API (REST) and processing the result. The code is designed using OOP and inheritance where possible.

![ad-tappx](assets/readme/ad-pic-sample.jpg)

## Project Structure

The project has the following structure:

- `Launcher.php`: Main class that will be executed to check the test.
- `Request.txt`: A JSON file that contains an example of data to be processed and sent to the AdNetwork.
- `Output/`: A folder where the output file will be saved.
- `Networks/`
  - `BaseClass.php`: Base class that implements common points/parts/members and functions for all AdNetworks.
  - `TappxClass.php`: Class that implements the AdNetwork specific details to connect with Tappx AdNetwork.




