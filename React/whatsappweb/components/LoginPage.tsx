import React, { useEffect, useState } from "react";
import Image from "next/image";
import { hash } from "crypto";

interface LoginProps {
  setIsAuthenticated: (auth: boolean) => void;
  setUserData: (
    id: string,
    username: string,
    icon: string,
    token: string
  ) => void;
}

const Login: React.FC<LoginProps> = ({ setIsAuthenticated, setUserData }) => {
  const [username, setUsername] = useState<any>("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  useEffect(() => {
    const token = localStorage.getItem("authToken");
    const expirationTime = localStorage.getItem("authTokenExpiration");

    if (token && expirationTime && Date.now() < parseInt(expirationTime)) {
      fetch("http://localhost:8000/api/verify-token", {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            setUserData(
              data.user.id,
              data.user.username,
              data.user.icon,
              token
            );
            setIsAuthenticated(true);
          } else {
            localStorage.removeItem("authToken");
          }
        })
        .catch((error) => {
          console.error("Errore nella verifica del token:", error);
        });
    } else {
      localStorage.removeItem("authToken");
      localStorage.removeItem("authTokenExpiration");
      console.log("Nessun utente loggato");
    }
  }, []);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!username || !password) {
      setError("Inserisci sia Username che password.");
      return;
    }
    fetch("http://localhost:8000/api/login-user", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        username: username,
        password: password,
      }),
      credentials: "include",
    })
      .then((response) => {
        if (!response.ok) {
          return response.json().then((data) => {
            throw new Error(data.message || "Credenziali errate");
          });
        }
        return response.json();
      })
      .then((data) => {
        console.log("Utente loggato con successo");
        localStorage.setItem("authToken", data.token);
        const expirationTime = Date.now() + 12000000; // 60000 per un minuto
        localStorage.setItem("authTokenExpiration", expirationTime.toString());
        setIsAuthenticated(true);
        setUserData(data.id, data.username, data.icon, data.token); // Passa l'ID, lo username, l'icona e il token personale
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
        <form id="login" onSubmit={handleSubmit}>
          <input
            id="username"
            autoComplete="Martin Trajkovski"
            type="text"
            placeholder="Username"
            value={username}
            onChange={(e) => setUsername(e.target.value)}
          />
          <input
            id="password"
            type="password"
            placeholder="Password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <button id="bottone" type="submit">
            Login
          </button>
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
