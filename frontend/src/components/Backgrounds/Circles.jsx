import Circle from '@components/Shapes/Circle';

const CircleGroup = () => {
  return (
    <>
      <Circle bottom='-100px' left='-100px' />
      <Circle bottom='210px' left='-70px' height='180px' width='180px' />
      <Circle top='-100px' right='-150px' />
      <Circle top='190px' right='100px' height='150px' width='150px' />
      <Circle top='180px' left='50px' height='90px' width='90px' />
      <Circle top='600px' right='100px' height='110px' width='110px' />
    </>
  );
};

export default CircleGroup;
