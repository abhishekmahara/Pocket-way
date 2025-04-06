document.addEventListener("DOMContentLoaded", () => {
    const routeBtn = document.getElementById("route-btn");
    const routeSection = document.getElementById("route-section");
    const busLine = document.getElementById("bus-line");
  
    const buses = [
      { name: "KSRTC Express 101", time: "8:00 AM", stop: "Majestic", price: "₹400" },
      { name: "City Shuttle 205", time: "10:00 AM", stop: "Hubli", price: "₹300" },
      { name: "GreenLine AC Coach", time: "1:30 PM", stop: "Kumta", price: "₹350" },
      { name: "Local Bus 77", time: "3:45 PM", stop: "Gokarna", price: "₹100" }
    ];
  
    routeBtn.addEventListener("click", () => {
      routeSection.classList.add("show");
  
      // Clear if already populated
      busLine.innerHTML = "";
  
      buses.forEach((bus) => {
        const div = document.createElement("div");
        div.className = "bus-stop";
        div.innerHTML = `
          <div class="stop-circle"></div>
          <div class="bus-info">
            <h4>${bus.name}</h4>
            <p>Stop: ${bus.stop} | Time: ${bus.time} | Fare: ${bus.price}</p>
            <a href="https://www.redbus.in/" target="_blank" class="book-btn">Book From Redbus</a>
          </div>
        `;
        busLine.appendChild(div);
      });
  
      // Disable button
      routeBtn.disabled = true;
      routeBtn.style.opacity = 0.6;
    });
  });
  