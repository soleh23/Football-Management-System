import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Statement;

public class FMSDatabase {
	public static void main(String args[]){
		String url = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/mehmet_turanboy";
		String username = "mehmet.turanboy";
		String password = "1ky0yl0r";

		System.out.println("Connecting to database...");

		// connecting to database
		Connection connection;
		try {
			connection = DriverManager.getConnection(url, username, password);
			System.out.println("Database connected!");
		}
		catch (SQLException e) {
			throw new IllegalStateException("Cannot connect the database!", e);
		}

		// dropping existing tables
		Statement dropStatement;
/*
 * CREATE TABLE User(
ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
25
username varchar(25) NOT NULL,
password varchar(25) NOT NULL,
type int NOT NULL,
UNIQUE (username)
);*/
		// dropping User table
		/*try{
			System.out.println("Dropping User Table");
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE User";
			dropStatement.executeUpdate(dropCustomer);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("User Table Dropped");


		// creating tables
		Statement statement;

		// creating customer table
		try{
			System.out.println("Creating User Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE User " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" username VARCHAR(25) NOT NULL, " +
					" password VARCHAR(25) NOT NULL, " +
					" type VARCHAR(10) NOT NULL, " +
					" UNIQUE (username)) " +
					" ENGINE InnoDB";
			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("User Table Created");


		// Updating Tables
		PreparedStatement preparedStatement;

		// insert tuples into customer
		try{
			System.out.println("Inserting tuples into User table");
			String sql;
			sql = "INSERT INTO User " +
					"(username, password, type)" +
					"VALUES (?, ?, ?);";
			String[][] tuples = new String[][]{{"kobramehmet", "iyibayramlar", "admin"},
												{"cssdemir", "css", "director"},
												{"shamil", "bootstrap", "coach"},
												{"soleh", "soleh98", "fan"},
												{"selena", "gomez", "player"},
												{"elon", "musk", "guest"},
												{"john", "john", "agent"}};

			for (int i = 0; i < tuples.length; i++){
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.setString(3, tuples[i][2]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into User table inserted");

	}
	*/



	try{
		System.out.println("Dropping Player Table");
		dropStatement = connection.createStatement();
		String dropCustomer = "DROP TABLE Player";
		dropStatement.executeUpdate(dropCustomer);
	}
	catch (Exception e){
		System.out.println(e);
	}
	System.out.println("Player Table Dropped");


	// creating tables
	Statement statement;

	// creating customer table
	try{ 								// BUT IT DOES NOT HAVE ANY DEPENDECY WITH AGENT YET. JUST TRYING
		System.out.println("Creating Player Table");
		statement = connection.createStatement();
		String user = "CREATE TABLE Player " +
				"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
				" username VARCHAR(25) NOT NULL, " +
				" password VARCHAR(25) NOT NULL, " +
				" type VARCHAR(10) NOT NULL, " +
				" name VARCHAR(20) NOT NULL, " +
				" surname VARCHAR(20) NOT NULL, " +
				" age INT NOT NULL, " +
				" salary INT NOT NULL, " +
				" nationality VARCHAR(15) NOT NULL, " +
				" birthdate DATE NOT NULL, " +
				" UNIQUE (username), " +
				" FOREIGN KEY(ID) REFERENCES User(Id))" +
				" ENGINE InnoDB";
		statement.executeUpdate(user);
	}
	catch (Exception e){
		System.out.println(e);
	}
	System.out.println("Player Table Created");


	// Updating Tables
	PreparedStatement preparedStatement;

	// insert tuples into customer
	try{
		System.out.println("Inserting tuples into Player table");
		String sql;
		sql = "INSERT INTO Player " +
				"(username, password, type, name, surname, age, salary, nationality, birthdate)" +
				"VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
		String[][] tuples = new String[][]{{"kobramehmet", "iyibayramlar", "admin","Pakize", "Yildirim", "18", "100","Kurt", "2000-10-10"}};

		for (int i = 0; i < tuples.length; i++){
			preparedStatement = connection.prepareStatement(sql);
			preparedStatement.setString(1, tuples[i][0]);
			preparedStatement.setString(2, tuples[i][1]);
			preparedStatement.setString(3, tuples[i][2]);
			preparedStatement.setString(4, tuples[i][3]);
			preparedStatement.setString(5, tuples[i][4]);
			preparedStatement.setString(6, tuples[i][5]);
			preparedStatement.setString(7, tuples[i][6]);
			preparedStatement.setString(8, tuples[i][7]);
			preparedStatement.setString(9, tuples[i][8]);
			preparedStatement.executeUpdate();
		}
	}
	catch (Exception e){
		System.out.println(e);
	}
	System.out.println("Tuples into Player table inserted");

}

}

