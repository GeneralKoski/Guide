export async function send(to_name: string, from_name: string, email: string, phoneNumber: string, coupon: string, hasPartitaIVA: string) {
  const data = {
    service_id: 'service_47vwdkj',
    template_id: 'template_gukwbih',
    user_id: 'IfFdXey5ejzpRzs2T',
    template_params: {
      from_name: from_name,
      to_name: to_name,
      phoneNumber: phoneNumber,
      email: email,
      coupon: coupon,
      hasPartitaIVA: hasPartitaIVA,
    }
  };

  const res = await fetch('https://api.emailjs.com/api/v1.0/email/send', {
    method: 'POST',
    body: JSON.stringify(data),
    headers: { 'Content-Type': 'application/json' }
  })
  if (await res.text() === 'OK') {
    return res;
  } else {
    throw new Error('error sending email')
  }
}