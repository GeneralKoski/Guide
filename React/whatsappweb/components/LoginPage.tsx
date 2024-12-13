import React, { useEffect, useState } from "react";
import Image from "next/image";

interface LoginProps {
  setIsAuthenticated: (auth: boolean) => void;
  setUserData: (id: string, username: string, icon: string) => void;
}

interface User {
  id: string;
  username: string;
  password: string;
  icon: string;
}

const Login: React.FC<LoginProps> = ({ setIsAuthenticated, setUserData }) => {
  const [username, setUsername] = useState<any>("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  // useEffect(() => {
  //   fetch("http://localhost:8000/check-session", {
  //     method: "GET",
  //     credentials: "include", // Include i cookie per verificare la sessione
  //   })
  //     .then((response) => response.json())
  //     .then((data) => {
  //       if (data.username) {
  //         console.log("Sessione attiva:", data);
  //         setIsAuthenticated(true);
  //         setUserData(data.id, data.username, data.icon); // Setta i dati dell'utente
  //       } else {
  //         console.log(data.message); // Nessuna sessione attiva
  //       }
  //     })
  //     .catch((error) => {
  //       console.log("Errore nel controllo della sessione", error);
  //     });
  // }, []);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!username || !password) {
      setError("Inserisci sia Username che password.");
      return;
    }
    // fetch("http://localhost:8000/login-user", {
    //   method: "POST",
    //   headers: {
    //     "Content-Type": "application/x-www-form-urlencoded",
    //     Accept: "application/json",
    //   },
    //   body: new URLSearchParams({
    //     username: username,
    //     password: password,
    //   }),
    //   credentials: "include",
    // })
    //   .then((response) => response.json())
    //   .then((data) => {
    //     console.log("Utente loggato con successo");
    //     setIsAuthenticated(true);
    //     setUserData(data.id, data.username, data.icon); // Passa l'ID, lo username e l'icona
    //   })
    //   .catch((error) => {
    //     console.error("Errore nella fetch:", error);
    //     setError("Username o password non validi.");
    //   });
    // };

    fetch(
      `http://localhost:8000/login-user?username=${username}&password=${password}`
    )
      .then((response) => response.json())
      .then((data) => {
        console.log("Utente loggato con successo");
        setIsAuthenticated(true);
        setUserData(data.id, data.username, data.icon); // Passa l'ID, lo username e l'icona
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
