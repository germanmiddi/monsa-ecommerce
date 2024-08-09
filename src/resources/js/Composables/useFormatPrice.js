export const useFormatPrice = (price) => {

    const numericPrice = typeof price === 'string' ? parseFloat(price.replace(/[^\d.-]/g, '')) : price;

    // Verificar si el precio es un número válido
    if (isNaN(numericPrice)) {
      console.error('Invalid price value:', price);
      return 'N/A';
    }
  
    return numericPrice.toLocaleString('es-AR', {
      style: 'currency',
      currency: 'ARS',
      minimumFractionDigits: 0,
      maximumFractionDigits: 0,
    });
  };