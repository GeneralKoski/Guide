import React, { useState } from "react";
import Image from "next/image";

interface LoginProps {
  setIsAuthenticated: (auth: boolean) => void;
  setUserData: (id: string, username: string, icon: string) => void;
}

interface User {
  id: string;
  username: string;
  password: string;
}

const Login: React.FC<LoginProps> = ({ setIsAuthenticated, setUserData }) => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!username || !password) {
      setError("Inserisci sia Username che password.");
      return;
    }
    fetch(
      `http://localhost:3000/loginUser.php?username="${username}"&password="${password}"`
    )
      .then((response) => response.json())
      .then((data) => {
        console.log("I dati dell'utente loggato sono:", data);
        if (data.length > 0) {
          const foundUser = data.find(
            (u: User) => u.username === username && u.password === password
          );

          if (foundUser) {
            setIsAuthenticated(true);
            setUserData(foundUser.id, foundUser.username, foundUser.icon); // Passa l'ID, lo username e l'icona
          }
        }
      })
      .catch((error) => {
        console.error("Errore nella fetch:", error);
        setError("Username o password non validi.");
      });
  };

  return (
    <div>
      <span className="whatsapp">
        <Image
          src="/images/wa-wordmark.png"
          alt="WhatsApp"
          width={60}
          height={60}
        />
        WhatsApp
      </span>
      <button
        className="download"
        onClick={() => alert("Stai scaricando l'app per Desktop")}
      >
        Scarica
      </button>
      <div className="login-container">
        <h1>Accedi a WhatsApp Web</h1>
        <ul className="instructions">
          <li>Scrivi il tuo Username</li>
          <li>Scrivi la tua Password</li>
          <li>Premi INVIO oppure l'apposito bottone "Login"</li>
        </ul>
        <form onSubmit={handleSubmit}>
          <input
            type="text"
            placeholder="Username"
            value={username}
            onChange={(e) => setUsername(e.target.value)}
          />
          <input
            type="password"
            placeholder="Password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <button type="submit">Login</button>
          {error && <p style={{ color: "red" }}>{error}</p>}
        </form>
        <p className="encryption">
          <Image
            className="img-fluid lucchetto"
            src="/images/lucchetto.png"
            alt="Lock"
            width={20}
            height={20}
          />
          I tuoi messaggi personali sono protetti dalla crittografia end-to-end
        </p>
      </div>
    </div>
  );
};

export default Login;
