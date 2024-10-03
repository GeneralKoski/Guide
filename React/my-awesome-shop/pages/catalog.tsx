import { NextPage } from 'next';
import Airtable from 'airtable';
import { Product } from '../model/product';
import Image from 'next/image';

export async function getStaticProps() {
  // query here ...
  const base = new Airtable({ apiKey: process.env.AIRTABLE_API_KEY}).base('appvd4v9JpNS9sEbC');
  const result = await base('Products').select({
    //...
  }).all();

  return {
    props: {
      data: result.map(record => {
        return { id: record.id, ...record.fields}
      }),
    }
  }
}

interface CatalogProps {
  data: Product[]
}

const Catalog: NextPage<CatalogProps> = props => {
  console.log(props.data)
  return (
    <div>
      <h1>Catalog</h1>

      {
        props.data.map(p => {
            return <li key={p.id}>
            {
              p.Image &&
                <Image src={p.Image[0].url} width={p.Image[0].width / 2} height={p.Image[0].height / 2} alt={p.Title}/>
            }
          </li>
        })
        }
    </div>
  )
}

export default Catalog;