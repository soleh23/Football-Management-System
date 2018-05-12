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
												{"agent2", "agent2", "Sukru", "Alexandro", "18", "20000","Turkey", "2000-12-10"}};

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
		try{ 								// BUT IT DOES NOT HAVE ANY DEPENDECY WITH AGENT YET. JUST TRYING
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
											{"ramos", "ramos", "Sergio", "Ramos", "32", "5000000", "Spain", "Defender", "1986-08-10", "1"}};

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
												{"English Premier League", "2001-11-11","2002-11-11", "England"}};

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
					"(name, transfer_budget, annual_wage_budget, city, establishment_date,value,stadium )" +
					"VALUES (?, ?, ?, ?, ? , ?, ? );";
			String[][] tuples = new String[][]{{"Real Madrid", "1000000", "500000", "Madrid", "1902-03-06", "10000000", "Santiago Bernabeu"},
											{"Barcelona", "30000000", "553000","Barcelona", "1912-12-06", "15000000", "Camp Nou"},
											{"Atletico Madrid", "500000", "13000","Madrid", "1945-12-06", "12000000", "Some unknown Stadium"}};

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
			String[][] tuples = new String[][]{{"20:00", "21:45", "Santiago Bernabeu", "2001-11-11", "1", "2"},
												{"20:00", "21:45", "Camp Nou", "2001-11-19", "2", "3"}};

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
			String[][] tuples = new String[][]{{"jonsmith", "jonsmith", "Jon", "Smith", "44", "100000", "USA", "1974-10-10", "1"},
												{"alibaba", "alibaba", "Ali", "Baba", "70", "120000", "Turkey", "1948-09-12", "2"}};

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
			String[][] tuples = new String[][]{{"zineddin", "zineddin", "Zineddin", "Zidan", "50", "120000","France", "1968-10-10","1","1"}, 
												{"barcacoach", "barcacoach", "Barcelona", "Couchinho", "50", "120000","Spain", "1968-10-10","1","2"},
												{"atleticocoach", "atleticocoach", "Atletico", "Couchinho", "50", "120000","Bangladesh", "1968-10-10","1","3"}};

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
					String[][] tuples = new String[][]{{"fandaniel", "fandaniel", "Daniel", "Cormier", "1"}};

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

				// insert tuples into Fan
				try{
					System.out.println("Inserting tuples into Transfer_Offer table");
					String sql;
					sql = "INSERT INTO Transfer_Offer " +
							"(price, transferDate, status, playerID, toDirectorID, fromDirectorID)" +
							"VALUES (?, ?, ?, ?, ?, ?);";
					String[][] tuples = new String[][]{{"60000000", "2018-01-01", "0", "1", "1", "2"}};

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
							"VALUES (?, ?, ?, ?, ?);";
					String[][] tuples = new String[][]{{"15", "0", "0", "1", "1"}, 
														{"76", "0", "0", "1", "1"}, 
														{"90", "0", "0", "1", "1"},
														{"33", "0", "0", "2", "2"},
														{"65", "0", "0", "2", "3"}};

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
							"VALUES (?, ?);";
					String[][] tuples = new String[][]{{"1", "3"},
														{"1", "2"}, 
														{"1", "1"}};

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
							"VALUES (?, ?);";
					String[][] tuples = new String[][]{{"1", "1"}};

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
							"VALUES (?, ?, ?, ?);";
					String[][] tuples = new String[][]{{"1", "1", "2009-09-01", null},
														{"2", "2", "2000-09-01", null},
														{"3", "3", "2005-10-07", null},
														{"1", "4", "2003-10-07", null},};

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
														{"1", "2"}};

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
														{"2", "2", "2", "45000", "2025-12-23", "1"},
														{"4", "1", "1", "48000", "2021-12-23", "0"}};

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
														{"Russia"},
														{"Turkey"},
														{"Italy"}};

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

