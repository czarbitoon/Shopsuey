import { Button, Stack } from '@mui/material';
import axios from 'axios';
import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { get } from '../api/CallApi';
import Card from '../components/Card';

const Product = () => {
  const [products, setProducts] = useState([]);
  const navigate = useNavigate();
  const handleLogout = () => {
    localStorage.clear();
    get('/logout');
    navigate('/');
  };

  useEffect(() => {
    axios.defaults.headers.common = {
      Authorization: `Bearer ${localStorage.getItem('token')}`,
    };
    const getData = async () => {
      const res = await get('/products');
      if (res.status === 200) setProducts(res.data.data);
    };
    getData();
  }, []);

  return (
    <Stack>
      <Stack
        display={'flex'}
        justifyContent='center'
        flexDirection={'row'}
        mt={3}
      >
        <Button
          onClick={() => navigate('/products/dashboard')}
          sx={{ width: 100 }}
        >
          Dashboard
        </Button>
        <Button onClick={handleLogout} sx={{ width: 100 }}>
          Logout
        </Button>
      </Stack>
      <Stack
        sx={{
          display: 'flex',
          flexDirection: 'row',
          justifyContent: 'center',
          alignItems: 'center',
          gap: 4,
        }}
      >
        {products.map((product, index) => (
          <Card key={product.id} product={product} index={index} />
        ))}
      </Stack>
    </Stack>
  );
};

export default Product;
