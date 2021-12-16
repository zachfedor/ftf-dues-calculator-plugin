(function() {
  function calculateDues(sales) {
    let dues;
    if (sales < 125000) dues = 400;
    else if (sales < 2000000) {
      dues = (sales * 0.0015) + 250;
    } else {
      dues = ((sales - 2000000) * 0.0001) + 3000;
    }
    
    return Math.min(10000, dues).toFixed(2);
  }
  
  function updateDues(event) {
    const sales = Number(event.target.value);
    
    const dues = calculateDues(sales);
    
    document.getElementById("dues").value = dues;
  }
  
  document.getElementById("sales").addEventListener("input", updateDues);
})()