import { defineConfig } from 'vite';
import path from 'path';
import react from '@vitejs/plugin-react-swc';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  esbuild: {
    include: /\.js$/,
    exclude: [],
    loader: 'jsx'
  },
  resolve: {
    alias: {
      '@/': path.resolve(__dirname, './'),
      '@shared': path.resolve(__dirname, './src/shared'),
      '@components': path.resolve(__dirname, './src/components'),
      '@views': path.resolve(__dirname, './src/views'),
      '@router': path.resolve(__dirname, './src/router'),
      '@data': path.resolve(__dirname, './src/data'),
      '@lib': path.resolve(__dirname, './src/shared/lib'),
      '@api': path.resolve(__dirname, './src/shared/api'),
      '@context': path.resolve(__dirname, './src/shared/context'),
      '@assets': path.resolve(__dirname, './src/shared/assets'),
      '@query': path.resolve(__dirname, './src/shared/query'),
      '@store': path.resolve(__dirname, './src/shared/store')
    }
  }
});
