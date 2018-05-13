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
		PreparedStatement preparedStatement;
		Statement statement;

		deletingTables();

		// creating tables

		/* Creating Agent Table */ /**********************************************************************************************/

		try{
			System.out.println("Creating Agent Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Agent " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" username VARCHAR(25) NOT NULL, " +
					" password VARCHAR(25) NOT NULL, " +
					" name VARCHAR(20) NOT NULL, " +
					" surname VARCHAR(20) NOT NULL, " +
					" age INT NOT NULL, " +
					" salary INT NOT NULL, " +
					" nationality VARCHAR(15) NOT NULL, " +
					" birthdate DATE NOT NULL, " +
					" UNIQUE (username))" +
					" ENGINE InnoDB";
			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Agent Table Created");



		// insert tuples into agent
		try{
			System.out.println("Inserting tuples into Agent table");
			String sql;
			sql = "INSERT INTO Agent " +
					"(username, password, name, surname, age, salary, nationality, birthdate)" +
					"VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
			String[][] tuples = new String[][]{{"agent1", "agent1", "Jeorge", "Mendes", "18", "30000","Portugal", "2000-10-10"},
				{"agent2", "agent2", "Sukru", "Alexandro", "18", "20000","Turkey", "2000-12-10"},
				{"agent3", "agent3", "Mahmut", "Muhammed", "18", "40000","Israil", "2000-11-11"},
				{"agent4", "agent4", "Mehmet", "Turan", "18", "50000","Misir", "1995-11-11"}};

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
					preparedStatement.executeUpdate();
				}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Agent table inserted");



		/*Creating Player Table *****************************************************************************************************/
		try{ 								
			System.out.println("Creating Player Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Player " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" username VARCHAR(25) NOT NULL, " +
					" password VARCHAR(25) NOT NULL, " +
					" name VARCHAR(20) NOT NULL, " +
					" surname VARCHAR(20) NOT NULL, " +
					" age INT NOT NULL, " +
					" salary INT NOT NULL, " +
					" nationality VARCHAR(15) NOT NULL, " +
					" position VARCHAR(15) NOT NULL, " +
					" birthdate DATE NOT NULL, " +
					" agent_ID INT, " +
					" FOREIGN KEY (agent_ID) REFERENCES Agent(ID), " +
					" UNIQUE (username))" +
					" ENGINE InnoDB";
			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Player Table Created");


		// insert tuples into Player
		try{
			System.out.println("Inserting tuples into Player table");
			String sql;
			sql = "INSERT INTO Player " +
					"(username, password, name, surname, age, salary, nationality, position, birthdate, agent_ID)" +
					"VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			String[][] tuples = new String[][]{{"cr7", "cr7", "Cristiano", "Ronaldo", "33", "80000000", "Portugal", "Forward", "1985-10-10", "1"},
				{"messi", "messi", "Lionel", "Messi", "30", "79000000", "Argentina", "Forward", "1987-10-10", "2"},
				{"grizman", "grizman", "Antuan", "Grizman", "27", "1000000", "France", "Forward", "1990-08-10", "1"},
				{"salah", "salah", "Muhammed", "Salah", "25", "2000000", "Egypt", "Forward", "1992-08-10", "3"},
				{"navas", "navas", "Keylor", "Navas", "27", "1000000", "Costa Rica", "GoalKeeper", "1994-08-10", "3"},
				{"hasan", "hasan", "Hasan Ali", "Kaldirim", "26", "1000000", "Greek", "Defence", "1994-08-10", "4"},
				{"varane", "varane", "Rafel", "Varane", "27", "300000", "France", "Defence", "1993-08-10", "1"},
				{"carvajal", "carvajal", "Dani", "Carvajal", "25", "23000000", "Spain", "Defence", "1993-08-10", "3"},
				{"marcelo", "marcelo", "Marcelo", "Silva", "30", "50000000", "Brasil", "Defance", "1988-08-10", "3"},
				{"modric", "modric", "Luka", "Modric", "30", "22000000", "Crotia", "Midfilder", "1990-08-10", "3"},
				{"kroos", "kroos", "Toni", "Kroos", "28", "333000000", "Germany", "Midfilder", "1990-08-10", "3"},
				{"casemiro", "casemiro", "Casemiro", "Silva", "25", "344000000", "Brasil", "Midfilder", "1990-08-10", "4"},
				{"bale", "bale", "Gareth", "Bale", "28", "888000000", "Wales", "Forward", "1990-08-10", "1"},
				{"karim", "karim", "Karim", "Benzama", "27", "55000000", "France", "Forward", "1992-08-10", "4"},
				{"kovacic", "kovacic", "Mateo", "Kovacic", "22", "333000000", "Crotia", "Forward", "1991-08-10", "4"}};

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
					preparedStatement.setString(10, tuples[i][9]);
					preparedStatement.executeUpdate();
				}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Player table inserted");

		/* League Table Creation */ /* ***************************************************************************************************/

		try{ 
			System.out.println("Creating League Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE League " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" name VARCHAR(30) NOT NULL, " +
					" start_date DATE NOT NULL, " +
					" end_date DATE NOT NULL, " +
					" countryName VARCHAR(20) NOT NULL)" +
					" ENGINE InnoDB";
			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("League Table Created");

		// insert tuples into League
		try{
			System.out.println("Inserting tuples into League table");
			String sql;
			sql = "INSERT INTO League " +
					"(name, start_date, end_date, countryName)" +
					"VALUES (?, ?, ?, ?);";
			String[][] tuples = new String[][]{{"La Liga", "2001-11-11","2002-11-11", "Spain"},
				{"Bundesliga", "2001-11-11","2002-11-11", "Germany"},
				{"English Premier League", "2001-11-11","2002-11-11", "England"},
				{"Seria A", "2001-11-11", "2002-11-11", "Italy"},
				{"Super Toto", "2001-11-11","2002-11-11", "Turkey"},
				{"TopAZ", "2001-11-11","2002-11-11", "Azerbaijan"},
				{"Eredivisie", "2001-11-11","2002-11-11", "Netherland"},
				{"Ligue 1", "2001-11-11","2002-11-11", "France"}};

				for (int i = 0; i < tuples.length; i++){
					preparedStatement = connection.prepareStatement(sql);
					preparedStatement.setString(1, tuples[i][0]);
					preparedStatement.setString(2, tuples[i][1]);
					preparedStatement.setString(3, tuples[i][2]);
					preparedStatement.setString(4, tuples[i][3]);
					preparedStatement.executeUpdate();
				}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into League table inserted");


		/* Club Table Creation */ /* ***************************************************************************************************/

		try{
			System.out.println("Creating Club Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Club " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" name VARCHAR(20) NOT NULL, " +
					" transfer_budget int NOT NULL, " +
					" annual_wage_budget int NOT NULL, " +
					" city VARCHAR(20) NOT NULL, " +
					" establishment_date DATE NOT NULL," +
					" value INT NOT NULL," +
					" stadium VARCHAR(20) NOT NULL )" +
					" ENGINE InnoDB";
			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Club Table Created");

		// insert tuples into club
		try{
			System.out.println("Inserting tuples into Club table");
			String sql;
			sql = "INSERT INTO Club " +
					"(name, transfer_budget, annual_wage_budget, city, establishment_date, value, stadium)" +
					"VALUES (?, ?, ?, ?, ? , ?, ? );";
			String[][] tuples = new String[][]
				{{"Real Madrid", "1000000", "500000", "Madrid", "1902-03-06", "10000000", "Santiago Bernabeu"},
				{"Barcelona", "30000000", "553000","Barcelona", "1912-12-06", "15000000", "Camp Nou"},
				{"Atletico Madrid", "500000", "13000","Madrid", "1945-12-06", "12000000", "	Metropolitano"},
				{"Galatasaray", "200000", "13000","Istanbul", "1905-12-06", "15000000", "Turk Telekom"},
				{"Fenerbahce", "300000", "14000", "Istanbul", "1906-12-06", "16000000", "Sukru Saracoglu"},
				{"Akhisar", "200000", "15000","Manisa", "1907-12-06", "17000000", "19 Mayis"},
				{"Ankaragucu", "200000", "16000","Ankara", "1908-12-06", "18000000", "Ankara 19 mayis"},
				{"Valencia", "200000", "17000","Valencia", "1909-12-06", "19000000", "Mestalle"},
				{"Villarreal", "200000", "18000","Castellon", "1910-12-06", "11000000", "La Ceramica"},
				{"Sevilla", "200000", "19000", "Sevilla", "1911-12-06", "12000000", "Ramon Sanchez"},
				{"Getafe", "200000", "20000","Madrid", "1912-12-06", "13000000", "Coliseum Alfonso"},
				{"Manchester United", "200000", "21000", "Manchester", "1913-12-06", "20000000", "Old Trafford"},
				{"Manchester City", "200000", "22000","Manchester", "1914-12-06", "21000000", "Etihad"},
				{"Tottenham", "200000", "23000","Tottenham", "1915-12-06", "22000000", "Wembley"},
				{"Chelsea", "200000", "24000","London", "1916-12-06", "23000000", "Stamford Bridge"},
				{"Liverpool", "200000", "25000","Liverpool", "1917-12-06", "24000000", "Anfield"},
				{"Arsenal", "200000", "26000","London", "1918-12-06", "25000000", "Emirates"},
				{"Bayern Munich", "200000", "26000","London", "1918-12-06", "25000000", "Allianz Arena"},
				{"Juventus", "200000", "26000","London", "1918-12-06", "25000000", "Allianz"},
				{"Neftci", "200000", "26000", "Baku", "1918-12-06", "25000000", "Tofig Bahramov"},
				{"Ajax", "200000", "26000", "Amsterdam", "1918-12-06", "25000000", "Johan Cruyff"},
				{"Marseille", "200000", "26000", "Marseille", "1918-12-06", "25000000", "Stade Velodrome"}
			};

			for (int i = 0; i < tuples.length; i++){
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.setString(3, tuples[i][2]);
				preparedStatement.setString(4, tuples[i][3]);
				preparedStatement.setString(5, tuples[i][4]);
				preparedStatement.setString(6, tuples[i][5]);
				preparedStatement.setString(7, tuples[i][6]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into club table inserted");



		/* Game Table Creation */ /* ***************************************************************************************************/

		try{ 
			System.out.println("Creating Game Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Game " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" start_time VARCHAR(20) NOT NULL, " +
					" end_time VARCHAR(20) NOT NULL, " +
					" stadium VARCHAR(20) NOT NULL, " +
					" game_date DATE NOT NULL, " +
					" home_teamID INT, " +
					" away_teamID INT, " +
					" FOREIGN KEY (home_teamID) REFERENCES Club(ID), " +
					" FOREIGN KEY (away_teamID) REFERENCES Club(ID))" +
					" ENGINE InnoDB";
			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Game Table Created");

		// insert tuples into Game
		try{
			System.out.println("Inserting tuples into Game table");
			String sql;
			sql = "INSERT INTO Game " +
					"(start_time, end_time, stadium, game_date, home_teamID, away_teamID)" +
					"VALUES (?, ?, ?, ?, ?, ?);";
			String[][] tuples = new String[][]{{"20:00", "21:45", "Santiago Bernabeu", "2011-11-11", "1", "3"},
				{"21:00", "22:45", "Santiago Bernabeu", "2011-11-30", "2", "1"},
				{"22:00", "23:45", "Camp Nou", "2018-11-12", "2", "3"},
				{"19:00", "20:45", "Metropolitano", "2018-11-15", "3", "2"},
				{"21:00", "22:45", "Turk Telekom", "2003-11-19", "4", "3"},
				{"21:00", "22:45", "Turk Telekom", "2002-11-16", "4", "5"},
				{"22:00", "23:45", "Ankara 19 mayis", "2006-11-18", "6", "5"},
				{"20:00", "21:45", "Mastelle", "2009-11-19", "8", "9"},
				{"21:00", "22:45", "Old Trafford", "2018-11-17", "12", "14"},
				{"20:00", "21:45", "Etihad", "2018-11-11", "13", "15"}
			};

			for (int i = 0; i < tuples.length; i++){
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.setString(3, tuples[i][2]);
				preparedStatement.setString(4, tuples[i][3]);
				preparedStatement.setString(5, tuples[i][4]);
				preparedStatement.setString(6, tuples[i][5]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Game table inserted");


		/* Director Table Creation */ /* ***************************************************************************************************/

		try{ 								
			System.out.println("Creating Director Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Director " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" username VARCHAR(25) NOT NULL, " +
					" password VARCHAR(25) NOT NULL, " +
					" name VARCHAR(20) NOT NULL, " +
					" surname VARCHAR(20) NOT NULL, " +
					" age INT NOT NULL, " +
					" salary INT NOT NULL, " +
					" nationality VARCHAR(15) NOT NULL, " +
					" birthdate DATE NOT NULL, " +
					" club_ID INT, " +
					" FOREIGN KEY (club_ID) REFERENCES Club(ID), " +
					" UNIQUE (username))" +
					" ENGINE InnoDB";
			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Director Table Created");

		// insert tuples into Director
		try{
			System.out.println("Inserting tuples into Director table");
			String sql;
			sql = "INSERT INTO Director " +
					"(username, password, name, surname, age, salary, nationality, birthdate, club_ID)" +
					"VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
			String[][] tuples = new String[][] {{"jonsmith", "jonsmith", "Jon", "Smith", "44", "100000", "USA", "1974-10-10", "1"},
				{"alibaba", "alibaba", "Ali", "Baba", "70", "120000", "Turkey", "1948-09-12", "2"},
				{"solehbaba", "solehbaba", "Soleh", "Baba", "77", "120000", "Tacikistan", "1941-09-12", "3"},
				{"demirbaba", "demirbaba", "Demir", "Baba", "71", "120000", "Turkey", "1947-09-12", "4"},
				{"shamilbaba", "shamilbaba", "shamil", "Baba", "73", "127000", "Azerbeijan", "1945-09-12", "5"},
				{"mehmetbaba", "mehmetbaba", "Mehmet", "Baba", "78", "1200", "Turkey", "1936-09-12", "6"},
				{"dursun", "dursun", "Dursun", "Ozbek", "60", "1200000", "Turkey", "1958-09-12", "7"},
				{"aziz", "aziz", "Aziz", "Yildirim", "60", "10020000", "France", "1958-09-12", "8"},
				{"flarentino", "flarentino", "Flarentino", "Perez", "61", "120000", "Brasil", "1959-09-12", "9"},
				{"demirbaba2", "demirbaba2", "Demir2", "Baba", "71", "120000", "Turkey", "1947-09-12", "10"},
				{"shamilbaba2", "shamilbaba2", "shamil2", "Baba", "73", "127000", "Azerbeijan", "1945-09-12", "11"},
				{"mehmetbaba2", "mehmetbaba2", "Mehmet2", "Baba", "78", "1200", "Turkey", "1936-09-12", "12"},
				{"dursun1", "dursun1", "Dursun1", "Ozbek1", "60", "1200000", "Turkey", "1958-09-12", "13"},
				{"aziz1", "aziz1", "Aziz", "Yildirim1", "60", "10020000", "France", "1958-09-12", "14"},
				{"muzo", "muzo", "muzo", "muzo", "71", "120000", "Turkey", "1947-09-12", "15"},
				{"samo", "samo", "samo", "samo", "73", "127000", "Azerbeijan", "1945-09-12", "16"},
				{"eren", "eren", "eren", "eren", "78", "1200", "Turkey", "1936-09-12", "17"}};

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
		System.out.println("Tuples into Director table inserted");

		//creating coach table
		try{
			System.out.println("Creating Coach Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Coach " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" username VARCHAR(25) NOT NULL, " +
					" password VARCHAR(25) NOT NULL, " +
					" name VARCHAR(20) NOT NULL, " +
					" surname VARCHAR(20) NOT NULL, " +
					" age INT NOT NULL, " +
					" salary INT NOT NULL, " +
					" nationality VARCHAR(15) NOT NULL, " +
					" birthdate DATE NOT NULL, " +
					" AgentID int NOT NULL," +
					" ClubID int NOT NULL," +
					" FOREIGN KEY (ClubID) REFERENCES Club(ID)," +
					" FOREIGN KEY (AgentID) REFERENCES Agent(ID),"+
					" UNIQUE (username))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Coach Table Created");

		// insert tuples into Coach
		try{
			System.out.println("Inserting tuples into Coach table");
			String sql;
			sql = "INSERT INTO Coach " +
					"(username, password, name, surname, age, salary, nationality, birthdate,AgentID,ClubID)" +
					"VALUES (?, ?, ?, ?, ?, ?, ?, ? , ?, ? );"; 
			String[][] tuples = new String[][]
				{{"zineddin", "zineddin", "Zineddin", "Zidan", "50", "120000","France", "1968-10-10","1","1"}, 
				{"barcacoach", "barcacoach", "Barcelona", "Couchinho", "50", "120000","Spain", "1968-10-10","1","2"},
				{"atleticocoach", "atleticocoach", "Atletico", "Couchinho", "50", "120000","Bangladesh", "1968-10-10","1","3"},
				{"solehbaba1", "solehbaba1", "Soleh1", "Baba1", "77", "120000","Tacikistan", "1941-10-10","2","4"},
				{"demirbaba1", "demirbaba1", "Demir1", "Baba1", "71", "120000","Turkey", "1968-10-10","3","5"},
				{"shamilbaba1", "shamilbaba1", "shamil1", "Baba1", "50", "120000","Azerbeijan", "1968-10-10","2","6"},
				{"mehmetbaba1", "mehmetbaba1", "Mehmet1", "Baba1", "40", "120000","Turkey", "1978-10-10","1","7"},
				{"realcoach", "realcoach", "Real", "Couchum", "55", "1200040","Spain", "1977-10-10","1","8"},
				{"roberto", "roberto", "Roberto", "Carlos", "51", "720000","Brasil", "1969-10-10","1","9"},
				{"ali", "ali", "ali", "ali", "50", "120000","Turkey", "1968-10-10","2","10"},
				{"veli", "veli", "veli", "veli", "50", "120000","Turkey", "1968-10-10","1","11"},
				{"mehmet", "mehmet", "mehmet", "mehmet", "50", "120000","Turkey", "1968-10-10","1","12"},
				{"ahmet", "ahmet", "ahmet", "ahmet", "50", "120000","Turkey", "1968-10-10","1","13"},
				{"jon", "jon", "jon", "jon", "50", "120000","English", "1968-10-10","3","14"},
				{"mahmut", "mahmut", "bayram", "mahmut", "50", "120000","Turkey", "1968-10-10","1","15"},
				{"mustafa", "mustafa", "mustafa", "mustafayev", "50", "120000","Azerbeijan", "1968-10-10","2","16"},
				{"salih", "salih", "mustafa", "rozibayev", "50", "120000","Tajikistan", "1968-10-10","1","17"}
			};

			for (int i = 0; i < tuples.length; i++)
			{
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
				preparedStatement.setString(10, tuples[i][9]);

				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Coach table inserted");

		//creating Fan table
		try{
			System.out.println("Creating Fan Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Fan " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" username VARCHAR(25) NOT NULL, " +
					" password VARCHAR(25) NOT NULL, " +
					" name VARCHAR(20) NOT NULL, " +
					" surname VARCHAR(20) NOT NULL, " +
					" favTeamID int NOT NULL, " +
					" FOREIGN KEY (favTeamID) REFERENCES Club(ID)," +
					" UNIQUE (username))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Fan Table Created");

		// insert tuples into Fan
		try{
			System.out.println("Inserting tuples into Fan table");
			String sql;
			sql = "INSERT INTO Fan " +
					"(username, password, name, surname, favTeamID)" +
					"VALUES (?, ?, ?, ?, ?);";
			String[][] tuples = new String[][]{{"fandaniel", "fandaniel", "Daniel", "Cormier", "1"},
				{"fanshamil", "fanshamil", "Shamil", "Ibra", "3"},
				{"fansoleh", "fansoleh", "Soleh", "Ruzi", "2"},
				{"fanmehmet", "fandmehmet", "Mehmet", "Turan", "4"},
				{"fanmezi", "fanmezi", "Mezi", "Abdul", "5"}};

				for (int i = 0; i < tuples.length; i++)
				{
					preparedStatement = connection.prepareStatement(sql);
					preparedStatement.setString(1, tuples[i][0]);
					preparedStatement.setString(2, tuples[i][1]);
					preparedStatement.setString(3, tuples[i][2]);
					preparedStatement.setString(4, tuples[i][3]);
					preparedStatement.setString(5, tuples[i][4]);
					preparedStatement.executeUpdate();
				}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Fan table inserted");

		//creating Transfer_Offer table

		try{
			System.out.println("Creating Transfer_Offer Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Transfer_Offer " +
					"(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, " +
					" price INT NOT NULL, " +
					" transferDate DATE NOT NULL, " +
					" status INT NOT NULL, " +
					" playerID INT NOT NULL, " +
					" fromDirectorID int NOT NULL, " +
					" toDirectorID int NOT NULL, " +
					" FOREIGN KEY (playerID) REFERENCES Player(ID)," +
					" FOREIGN KEY (fromDirectorID) REFERENCES Director(ID)," +
					" FOREIGN KEY (toDirectorID) REFERENCES Director(ID))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Transfer_Offer Table Created");

		// insert tuples into Transfer_Offer
		try{
			System.out.println("Inserting tuples into Transfer_Offer table");
			String sql;
			sql = "INSERT INTO Transfer_Offer " +
					"(price, transferDate, status, playerID, toDirectorID, fromDirectorID)" +
					"VALUES (?, ?, ?, ?, ?, ?);";
			String[][] tuples = new String[][]{{"60000000", "2018-01-01", "0", "1", "1", "2"},
				{"70000000", "2018-02-01", "1", "2", "2", "3"},
				{"80000000", "2018-03-01", "0", "3", "3", "6"}, 
				{"90000000", "2018-04-01", "1", "7", "1", "8"},
				{"50000000", "2018-05-01", "0", "1", "1", "10"}};

				for (int i = 0; i < tuples.length; i++)
				{
					preparedStatement = connection.prepareStatement(sql);
					preparedStatement.setString(1, tuples[i][0]);
					preparedStatement.setString(2, tuples[i][1]);
					preparedStatement.setString(3, tuples[i][2]);
					preparedStatement.setString(4, tuples[i][3]);
					preparedStatement.setString(5, tuples[i][4]);
					preparedStatement.setString(6, tuples[i][5]);
					preparedStatement.executeUpdate();
				}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Transfer_Offer table inserted");

		//creating Stats table
		try{
			System.out.println("Creating Stats Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Stats " +
					"(time INT NOT NULL, " +
					" action INT NOT NULL, " +
					" type INT NOT NULL, " +
					" gameID INT NOT NULL, " +
					" playerID int NOT NULL, " +
					" FOREIGN KEY (playerID) REFERENCES Player(ID)," +
					" FOREIGN KEY (gameID) REFERENCES Game(ID), " +
					" PRIMARY KEY (time, gameID))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Stats Table Created");

		// insert tuples into Stats
		try{
			System.out.println("Inserting tuples into Stats table");
			String sql;
			sql = "INSERT INTO Stats " +
					"(time, action, type, gameID, playerID)" +
					"VALUES (?, ?, ?, ?, ?);"; // CORRECT CORRECT CORRECT
			String[][] tuples = new String[][]{{"15", "0", "0", "1", "1"}, 
				{"76", "0", "0", "1", "1"}, 
				{"90", "0", "0", "1", "1"},
				{"33", "0", "0", "2", "2"},
				{"65", "0", "0", "2", "1"},
				{"35", "0", "0", "3", "3"},
				{"12", "0", "0", "4", "2"},
				{"25", "0", "0", "5", "6"},
				{"27", "0", "0", "6", "6"},
				{"89", "0", "0", "7", "4"}
			};

			for (int i = 0; i < tuples.length; i++)
			{
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.setString(3, tuples[i][2]);
				preparedStatement.setString(4, tuples[i][3]);
				preparedStatement.setString(5, tuples[i][4]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Stats table inserted");

		//creating League_Club table
		try{
			System.out.println("Creating League_Club Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE League_Club " +
					"(leagueID INT NOT NULL, " +
					" clubID INT NOT NULL, " +
					" FOREIGN KEY (leagueID) REFERENCES League(ID)," +
					" FOREIGN KEY (clubID) REFERENCES Club(ID), " +
					" PRIMARY KEY (leagueID, clubID))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("League_Club Table Created");

		// insert tuples into League_Club
		try{
			System.out.println("Inserting tuples into League_Club table");
			String sql;
			sql = "INSERT INTO League_Club " +
					"(leagueID, clubID)" +
					"VALUES (?, ?);"; // CORRECT CORRECT CORRECT CORRECT CORRECT CORRECT CORRECT 
			String[][] tuples = new String[][]{{"1", "3"},
				{"1", "2"}, 
				{"1", "1"},
				{"1", "8"},
				{"1", "9"},
				{"1", "10"},
				{"1", "11"},
				{"2", "18"},
				{"3", "12"},
				{"3", "13"},
				{"3", "14"},
				{"3", "15"},
				{"3", "16"},
				{"3", "17"},
				{"4", "19"},
				{"5", "4"}, //toto
				{"5", "5"},
				{"5", "6"},
				{"5", "7"},
				{"6", "20"},//top
				{"7", "21"},//eredevise
				{"8", "22"},//league 1
			};

			for (int i = 0; i < tuples.length; i++)
			{
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into League_Club table inserted");

		//creating League_Game table
		try{
			System.out.println("Creating League_Game Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE League_Game " +
					"(leagueID INT NOT NULL, " +
					" gameID INT NOT NULL, " +
					" FOREIGN KEY (leagueID) REFERENCES League(ID)," +
					" FOREIGN KEY (gameID) REFERENCES Game(ID), " +
					" PRIMARY KEY (leagueID, gameID))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("League_Game Table Created");

		// insert tuples into League_Game
		try{
			System.out.println("Inserting tuples into League_Game table");
			String sql;
			sql = "INSERT INTO League_Game " +
					"(leagueID, gameID)" +
					"VALUES (?, ?);"; // CORRECT CORRECT CORRECT CORRECT CORRECT CORRECT
			String[][] tuples = new String[][]{{"1", "1"},
				{"1", "2"},
				{"1", "3"},
				{"1", "4"},
				{"5", "5"},
				{"5", "6"},
				{"5", "7"},
				{"3", "8"},
				{"3", "9"},
			};

			for (int i = 0; i < tuples.length; i++)
			{
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into League_Game table inserted");

		//creating Plays table
		try{
			System.out.println("Creating Plays Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Plays " +
					"(clubID INT NOT NULL, " +
					" playerID INT NOT NULL, " +
					" startDate DATE NOT NULL, " +
					" endDate DATE, " +
					" FOREIGN KEY (clubID) REFERENCES Club(ID)," +
					" FOREIGN KEY (playerID) REFERENCES Player(ID), " +
					" PRIMARY KEY (clubID, playerID))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Plays Table Created");

		// insert tuples into Plays
		try{
			System.out.println("Inserting tuples into Plays table");
			String sql;
			sql = "INSERT INTO Plays " +
					"(clubID, playerID, startDate, endDate)" +
					"VALUES (?, ?, ?, ?);"; // CCORRECT CORRECT
			String[][] tuples = new String[][]{{"1", "1", "2009-09-01", "2012-09-01"}, 
				{"2", "2", "2000-09-01", "2005-09-01"},
				{"3", "3", "2005-10-07", "2010-09-01"},
				{"16", "4", "2000-09-01", "2004-09-01"},
				{"1", "5", "2005-10-07", "2013-09-01"},
				{"5", "6", "2009-09-01", "2012-09-01"}, 
				{"1", "7", "2000-09-01", "2040-09-01"},
				{"1", "8", "2005-10-07", "2022-09-01"},
				{"1", "9", "2009-09-01","2032-09-01"}, 
				{"1", "10", "2000-09-01", "2011-09-01"},
				{"1", "11", "2005-10-07", "2022-09-01"},
				{"1", "12", "2009-09-01", "2012-09-01"}, 
				{"1", "13", "2000-09-01", "2019-09-01"},
				{"1", "14", "2005-10-07", "2006-09-01"},
				{"1", "15", "2009-09-01", "2015-09-01"} 
			};
			for (int i = 0; i < tuples.length; i++)
			{
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.setString(3, tuples[i][2]);
				preparedStatement.setString(4, tuples[i][3]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Plays table inserted");

		//creating Subscribe table
		try{
			System.out.println("Creating Subscribe Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Subscribe " +
					"(fanID INT NOT NULL, " +
					" clubID INT NOT NULL, " +
					" FOREIGN KEY (fanID) REFERENCES Fan(ID)," +
					" FOREIGN KEY (clubID) REFERENCES Club(ID), " +
					" PRIMARY KEY (fanID, clubID))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Subscribe Table Created");

		// insert tuples into Subscribe
		try{
			System.out.println("Inserting tuples into Subscribe table");
			String sql;
			sql = "INSERT INTO Subscribe " +
					"(fanID, clubID)" +
					"VALUES (?, ?);";
			String[][] tuples = new String[][]{{"1", "1"},
				{"1", "2"},
				{"2", "1"},
				{"3", "2"},
				{"4", "5"},
				{"4", "2"},
				{"4", "12"},
				{"5", "2"},
				{"1", "7"}
			};

			for (int i = 0; i < tuples.length; i++)
			{
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Subscribe table inserted");

		//creating Contract table
		try{
			System.out.println("Creating Contract Table");
			statement = connection.createStatement();
			String user = "CREATE Table Contract " +
					"(playerID INT NOT NULL, " +
					" directorID INT NOT NULL, " +
					" agentID INT NOT NULL, " +
					" bonus INT NOT NULL, " +
					" expirationDate DATE NOT NULL, " +
					" status INT NOT NULL, " +
					" FOREIGN KEY (playerID) REFERENCES Player(ID)," +
					" FOREIGN KEY (directorID) REFERENCES Director(ID), " +
					" FOREIGN KEY (agentID) REFERENCES Agent(ID), " +
					" PRIMARY KEY (playerID, agentID))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Contract Table Created");

		// insert tuples into Contract
		try{
			System.out.println("Inserting tuples into Contract table");
			String sql;
			sql = "INSERT INTO Contract " +
					"(playerID, directorID, agentID, bonus, expirationDate, status)" +
					"VALUES (?, ?, ?, ?, ?, ?);";
			String[][] tuples = new String[][]{{"1", "1", "1", "50000", "2023-10-20", "1"},
				{"2", "2", "2", "45000", "2025-12-23", "1"}};

				for (int i = 0; i < tuples.length; i++)
				{
					preparedStatement = connection.prepareStatement(sql);
					preparedStatement.setString(1, tuples[i][0]);
					preparedStatement.setString(2, tuples[i][1]);
					preparedStatement.setString(3, tuples[i][2]);
					preparedStatement.setString(4, tuples[i][3]);
					preparedStatement.setString(5, tuples[i][4]);
					preparedStatement.setString(6, tuples[i][5]);
					preparedStatement.executeUpdate();
				}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Contract table inserted");

		//creating Admin table
		try{
			System.out.println("Creating Admin Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Admin " +
					"(username VARCHAR(20) NOT NULL, " +
					" password VARCHAR(20) NOT NULL, " +
					" PRIMARY KEY (username))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Admin Table Created");

		// insert tuples into Admin
		try{
			System.out.println("Inserting tuples into Admin table");
			String sql;
			sql = "INSERT INTO Admin " +
					"(username, password)" +
					"VALUES (?, ?);";
			String[][] tuples = new String[][]{{"admin", "admin"}};

			for (int i = 0; i < tuples.length; i++)
			{
				preparedStatement = connection.prepareStatement(sql);
				preparedStatement.setString(1, tuples[i][0]);
				preparedStatement.setString(2, tuples[i][1]);
				preparedStatement.executeUpdate();
			}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Admin table inserted");

		//creating Country table
		try{
			System.out.println("Creating Country Table");
			statement = connection.createStatement();
			String user = "CREATE TABLE Country " +
					"(name VARCHAR(30) NOT NULL, " +
					" PRIMARY KEY (name))" +
					" ENGINE InnoDB";

			statement.executeUpdate(user);
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Country Table Created");

		// insert tuples into Country
		try{
			System.out.println("Inserting tuples into Country table");
			String sql;
			sql = "INSERT INTO Country " +
					"(name)" +
					"VALUES (?);";
			String[][] tuples = new String[][]{{"Spain"}, 
				{"Germany"}, 
				{"England"}, 
				{"France"}, 
				{"Turkey"}, 
				{"Italy"},
				{"Azerbeijan"},
				{"Tajikistan"},
				{"Brasil"}};

				for (int i = 0; i < tuples.length; i++)
				{
					preparedStatement = connection.prepareStatement(sql);
					preparedStatement.setString(1, tuples[i][0]);
					preparedStatement.executeUpdate();
				}
		}
		catch (Exception e){
			System.out.println(e);
		}
		System.out.println("Tuples into Country table inserted");
	}
	public static void deletingTables ()
	{
		String url = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/mehmet_turanboy";
		String username = "mehmet.turanboy";
		String password = "1ky0yl0r";

		System.out.println("Deleting Tables");
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

		Statement dropStatement;

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Admin";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Admin Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Contract";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Contract Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Subscribe";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Subscribe Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Plays";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Plays Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE League_Club";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("League_Club Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE League_Game";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("League_Game Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Transfer_Offer";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Transfer_Offer Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Stats";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Stats Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Player";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Player Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Coach";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Coach Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Director";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Director Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Game";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Game Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE League";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("League Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}


		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Agent";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Agent Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Fan";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Fan Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Club";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Club Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

		try
		{
			dropStatement = connection.createStatement();
			String dropCustomer = "DROP TABLE Country";
			dropStatement.executeUpdate(dropCustomer);
			System.out.println("Country Table Dropped");
		}
		catch (Exception e){
			System.out.println(e);
		}

	}

}

