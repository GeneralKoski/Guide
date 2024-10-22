import '../styles/globals.css'
import '../styles/category.css'
import '../styles/post.css'
import '../styles/index.css'
import type { AppProps } from 'next/app'
import AppNavbar from '../components/AppNavbar'
import AppFooter from '@/components/AppFooter'

function MyApp({ Component, pageProps }: AppProps) {
    return <>
        <AppNavbar />
        <Component {...pageProps} />
        <AppFooter />
    </>
}

export default MyApp