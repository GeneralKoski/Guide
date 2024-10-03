import Layout from "@/layouts/Layout"
import Head from 'next/head';
import { send } from "@/services/emailjs.service"
import { ContactForm } from "@/types"
import { NextPage } from "next"
import Image from "next/image"
import { useState } from "react"

const ContactPage: NextPage = () => {
    const [form, setForm] = useState<ContactForm>({
        fullName: "",
        email: "",
        phoneNumber: "",
        coupon: "",
        hasPartitaIVA: "no",
        privacy: false,
    });
    const [privacy, setPrivacy] = useState<boolean>(false);

    function handleSubmit(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();
        const { fullName, email, phoneNumber, coupon, hasPartitaIVA } = form;
        send('Martin', fullName, email, phoneNumber, coupon || '', hasPartitaIVA)
        .then(() => {
          console.log('Email inviata!');
        })
        .catch((error) => {
          console.error(error);
        })
      }

    function handleChange(event: React.ChangeEvent<HTMLInputElement>) {
        setForm({
            ...form,
            [event.currentTarget.name]: event.currentTarget.value
        });
    }

    return (
        <Layout>
            <Head>
                <title>EasyFisco - Contatti</title>
                <meta name="description" content="EasyFisco gestisce i clienti e la fiscalità per te, per darti modo di dedicare il tuo tempo alle cose più importanti." />
            </Head>
            <header className="header" id="header">
                <div className="container">
                    <div className="row align-items-center">
                        <div className="col-lg-6">
                            <div className="text-container">
                                <h1 className="h1-large">Vuoi saperne di più? <span className="replace-me">Contattaci</span></h1>
                                <p className="p-large">Siamo disponibili 24/7 per rispondere ad ogni tua domanda</p>
                                <a className="btn-solid-lg" href="#contact-form">Vai al form</a>
                            </div>
                        </div>
                        <div className="col-lg-6">
                            <div className="image-container">
                                <Image 
                                    className="img-fluid"
                                    src="/images/kiwi.svg" 
                                    width={400}
                                    height={500}
                                    alt="Easy Fisco Header Image"
                                    priority
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div className="contact" id="contact-form">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <h2 className="heading">Compila il form <span>per essere contattato</span></h2>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-lg-12">
                            <form onSubmit={handleSubmit}>
                                <div className="row">
                                    <div className="col mb-4 text-start">
                                        <label htmlFor="fullName" className="form-label">Nome e cognome *</label>
                                        <input type="text" className="form-control" id="fullName" name="fullName" placeholder="Il tuo nome" aria-label="Nome e Cognome" required onChange={handleChange} value={form.fullName}/>
                                    </div>
                                    <div className="col mb-4 text-start">
                                        <label htmlFor="email" className="form-label">Email *</label>
                                        <input type="email" className="form-control" id="email" name="email" placeholder="La@tua.email" aria-label="Email" required onChange={handleChange} value={form.email}/>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col mb-4 text-start">
                                        <label htmlFor="phoneNumber" className="form-label">Telefono *</label>
                                        <input type="text" className="form-control" id="phoneNumber" name="phoneNumber" value={form.phoneNumber} onChange={handleChange} placeholder="123 456 7890" aria-label="Telefono" required/>
                                    </div>
                                    <div className="col mb-4 text-start">
                                        <label htmlFor="coupon" className="form-label">Coupon</label>
                                        <input type="text" className="form-control" id="coupon" name="coupon" value={form.coupon} onChange={handleChange} placeholder="ABC123" aria-label="Coupon"/>
                                    </div>
                                </div>
                                <div className="form-check text-start">
                                    <input type="radio" className="form-check-input" name="hasPartitaIVA" id="noPartitaIVA" defaultChecked onChange={handleChange} value="no"/>
                                    <label htmlFor="noPartitaIVA" className="form-check-label">
                                        Non ho una partita IVA e vorrei aprirne una
                                    </label>
                                </div>
                                <div className="form-check text-start">
                                    <input type="radio" className="form-check-input" name="hasPartitaIVA" id="siPartitaIVA" onChange={handleChange} value="si"/>
                                    <label htmlFor="siPartitaIVA" className="form-check-label">
                                        Ho già una partita IVA e vorrei passare a EasyFisco
                                    </label>
                                </div>
                                <div className="mt-4 form-check text-start">
                                    <input type="checkbox" className="form-check-input" value="privacy" name="privacy" id="privacy" checked={privacy} onChange={() => setPrivacy(!privacy)} required/>
                                    <label htmlFor="privacy" className="form-check-label">
                                        Ho letto e accetto l'informativa sulla Privacy
                                    </label>
                                </div>
                                <button className="btn-solid-lg" type="submit">INVIA</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </Layout>
    )
}

export default ContactPage;