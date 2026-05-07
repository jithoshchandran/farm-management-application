# BovineERP: Modules & Features Documentation

## 1. Livestock Management
The core of the system, providing a robust database for herd tracking and history.
*   **Detailed Cow Profiles**: Track tag numbers, names, breeds, weight, and status (Active, Pregnant, Dry, etc.).
*   **3-Generation Lineage (Pedigree)**: Visual tracking of Sire (Father) and Dam (Mother) records to understand genetic history.
*   **Acquisition History**: Record whether an animal was born on the farm or purchased, including purchase age, price, and vendor notes.
*   **Media Gallery**: High-resolution thumbnail and gallery storage for visual identification and growth monitoring.

## 2. Insemination & Breeding
Optimized tracking for farm reproduction cycles.
*   **Breeding Methods**: Log both Artificial Insemination (AI) and Natural breeding events.
*   **Gestation Tracking**: Automatic calculation of "Expected Calving Date" (283-day standard) upon recording a breeding event.
*   **Technician & Bull Management**: Directory of veterinarians/technicians and pedigree tracking for bulls.
*   **Success Monitoring**: Record results (Success/Failed) to track fertility trends.

## 3. Milk Production
Precision daily yield monitoring.
*   **Daily Yield Logs**: Record Morning and Evening yields for individual cows.
*   **Automated Aggregation**: Real-time calculation of total daily yield and historical averages.
*   **Safety Alerts (Withdrawal Warning)**: System automatically flags cows undergoing medical treatment, warning staff to discard milk during the withdrawal period.

## 4. Health & Treatment
Comprehensive veterinary record-keeping.
*   **Diagnosis & Prescription**: Log illness details, veterinarian advice, and medication dosages.
*   **Withdrawal Period Management**: Specific tracking of "Withdrawal Days" to ensure milk/meat safety.
*   **Medical Attachments**: Store digital copies of prescriptions and laboratory results.
*   **Treatment Status**: Monitor recovery progress from "Active" to "Completed."

## 5. Feed & Nutrition
Efficient resource allocation and cost control.
*   **Targeted Allocation**: Assign specific feed types to groups or individual cows.
*   **Inventory Integration**: Link allocations to feed stock to monitor consumption.
*   **Cost Analysis**: Real-time calculation of feeding costs based on quantity and cost-per-kg.

## 6. HR & Staff Management
Streamlined farm labor administration.
*   **Employee Database**: Track personal details, ID proofs, and join dates.
*   **Flexible Salary Structures**: Supports Daily, Weekly, and Monthly payment models.
*   **Performance Tracking**: Record remarks and leaves for staff evaluation.

## 7. Financial Management (Expenses)
Holistic view of farm expenditures.
*   **Categorized Expenses**: Logical grouping (e.g., Feed, Medical, Utilities) for better budgeting.
*   **Payment Status**: Track "Paid," "Pending," or "Partial" payments to manage cash flow.
*   **Expiry Alerts**: Track recurring costs or expiring contracts.

---
**Technical Foundation**: Built on Laravel & Filament, ensuring a high-performance, secure, and mobile-responsive administration interface.
