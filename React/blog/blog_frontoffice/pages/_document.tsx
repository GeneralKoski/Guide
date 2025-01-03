import Document, { Html, Head, Main, NextScript } from 'next/document'

class MyDocument extends Document {
    render() {
        return (
            <Html lang = "it">
                <Head>
                <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet"></link>
                <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet"></link>
                </Head>
                <body>
                    <Main/>
                    <NextScript />
                </body>
            </Html>
        )
    }
}

export default MyDocument;