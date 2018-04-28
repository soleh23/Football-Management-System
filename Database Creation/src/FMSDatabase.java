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
		try{
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
}

