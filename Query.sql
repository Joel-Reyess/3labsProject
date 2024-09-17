-- Tabla de roles
CREATE TABLE Roles (
    RolID INT PRIMARY KEY AUTO_INCREMENT,
    NombreRol VARCHAR(50) NOT NULL
);

-- Tabla de carreras
CREATE TABLE Carreras (
    CarreraID INT PRIMARY KEY AUTO_INCREMENT,
    NombreCarrera VARCHAR(100) NOT NULL
);

-- Tabla de edificios
CREATE TABLE Edificios (
    EdificioID INT PRIMARY KEY AUTO_INCREMENT,
    NombreEdificio VARCHAR(100) NOT NULL
);

-- Tabla de usuarios (modificada)
CREATE TABLE Usuarios (
    Matricula INT(20) PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    ApellidoP VARCHAR(100) NOT NULL,
    ApellidoM VARCHAR(100) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    RolID INT,
    FOREIGN KEY (RolID) REFERENCES Roles(RolID)
);

-- Tabla de estudiantes (modificada)
CREATE TABLE Estudiantes (
    Matricula INT(20) PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    ApellidoP VARCHAR(100) NOT NULL,
    ApellidoM VARCHAR(100) NOT NULL,
    Correo VARCHAR(100) NOT NULL,
    Grado VARCHAR(10) NOT NULL,
    Grupo VARCHAR(10) NOT NULL,
    CarreraID INT,
    FOREIGN KEY (CarreraID) REFERENCES Carreras(CarreraID)
);

-- Tabla de materiales (modificada)
CREATE TABLE Materiales (
    ItemID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion VARCHAR(255),
    Stock INT NOT NULL,
    EdificioID INT,
    FOREIGN KEY (EdificioID) REFERENCES Edificios(EdificioID)
);

-- Tabla de herramientas (modificada)
CREATE TABLE Herramientas (
    ItemID INT PRIMARY KEY AUTO_INCREMENT,
    NS VARCHAR(100) NOT NULL,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion VARCHAR(255),
    Stock INT NOT NULL,
    EdificioID INT,
    FOREIGN KEY (EdificioID) REFERENCES Edificios(EdificioID)
);

-- Tabla de prestamos (modificada)
CREATE TABLE PrestamosMateriales (
    PrestamoID INT PRIMARY KEY AUTO_INCREMENT,
    Matricula INT(20),
    ItemID INT NOT NULL,
    EdificioID INT,
    FechaPrestamo DATETIME NOT NULL,
    Cantidad INT NOT NULL,
    FOREIGN KEY (Matricula) REFERENCES Estudiantes(Matricula),
    FOREIGN KEY (EdificioID) REFERENCES Edificios(EdificioID),
    FOREIGN KEY (ItemID) REFERENCES Materiales(ItemID)
);


CREATE TABLE PrestamosHerramientas (
    PrestamoID INT PRIMARY KEY AUTO_INCREMENT,
    Matricula INT(20),
    ItemID INT NOT NULL,
    EdificioID INT,
    FechaPrestamo DATETIME NOT NULL,
    FechaDevolucion DATETIME,
    Cantidad INT NOT NULL,
    Estado Varchar(20) NOT NULL,
    FOREIGN KEY (Matricula) REFERENCES Estudiantes(Matricula),
    FOREIGN KEY (EdificioID) REFERENCES Edificios(EdificioID),
    FOREIGN KEY (ItemID) REFERENCES Herramientas(ItemID)
);
