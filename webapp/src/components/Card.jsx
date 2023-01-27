import { Button, Stack } from '@mui/material';
import * as React from 'react';
import { post } from '../api/CallApi';
import { colors } from '../utils/colors';

const Card = ({ product, index }) => {
  const handleProduct = async (productId) => {
    const res = await post(`/checkout/${productId}`);
    if (res.status === 200) {
      window.location.replace(res.data.url);
    }
  };
  return (
    <Stack
      sx={{
        display: 'flex',
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        height: '100vh',
      }}
    >
      <Stack
        sx={{
          width: 360,
          bgcolor: '#e3f2fd',
          boxShadow:
            'rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px',

          borderRadius: 10,
          p: 4,
          textAlign: 'center',
          height: 'auto',
        }}
      >
        <h2>{product?.name}</h2>
        <p>Install</p>
        <h2>${product?.price}</h2>
        <p>
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. At, eos
          deserunt? Sunt unde fugiat atque?
        </p>
        <Button
          variant='contained'
          sx={{ background: colors[index], borderRadius: 10, my: 2, py: 1 }}
          onClick={() => handleProduct(product?.id)}
        >
          Get Started
        </Button>
      </Stack>
    </Stack>
  );
};

export default Card;
