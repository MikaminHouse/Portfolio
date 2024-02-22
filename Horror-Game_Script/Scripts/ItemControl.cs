using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class ItemControl : MonoBehaviour
{
    private Ray itemRay;
    private ItemScript itemScript;

    //Item関数//
    public List<string> itemTypeList = new List<string>();  //アイテムの種類を格納
    public List<string> itemNameList = new List<string>();  //アイテムの名前を格納
    public List<Sprite> itemImageList = new List<Sprite>();  //アイテムの画像を格納
    public int listNumber = 0;  //リストの順番を指定する
    private int loop;  //繰り返す回数
    //crystal 変数//
    public Image crystalImage;
    //medicine drug変数//
    public int medicineCount;
    public int drugCount;
    //battry変数//
    public int batteryCount;
    public List<Image> batteryList = new List<Image>();
    //light変数//
    public GameObject playerArm;  //プレイヤーの腕を格納
    public Image lightImage;  //懐中電灯のUIを格納
    //Slot関数//
    public List<Image> slotImageList = new List<Image>();
    public Text slotText;  //メインスロットに装填されているアイテムの名前を格納
    //SlotMove関数//
    public bool canSlotMove;  //スロットの操作が可能かどうかを判断する
    //説明画像スクリプト//
    public ExplainScript explainScript;

    public kaiten kaiten;  //パチスロのスクリプトを格納
    public Sprite blankImage;  //アイテム使用後の空白画像


    // Update is called once per frame
    void Update()
    {
        if (canSlotMove) SlotMove();
        if(itemNameList.Count > 0) slotText.text = itemNameList[listNumber];  //メインスロットで選択しているアイテムの名前を表示
    }
    public void Item(GameObject item)  //アイテムを取得した時の関数
    {
        itemScript = item.GetComponent<ItemScript>();   //アイテムのスクリプトを取得
        //電池を取得した時の処理
        if (itemScript.itemType == "battery")
        {
            batteryList[batteryCount].gameObject.SetActive(true);  //電池UIを表示
            batteryCount += 1;  //電池の現在数を1増やす
            if (batteryCount == 4) batteryCount = 0;
            Destroy(item);  //電池を削除
        }
        //懐中電灯を取得した時の処理
        else if (itemScript.itemType == "light" || itemScript.itemType == "saber")
        {
            lightImage.gameObject.SetActive(true);  //懐中電灯のUIを表示させる
            item.transform.parent = Camera.main.gameObject.transform;  //プレイヤーの腕と親子関係を付ける
            item.transform.localEulerAngles = playerArm.transform.localEulerAngles;  //懐中電灯を正面に向けさせる
            item.transform.position = playerArm.transform.position;  //懐中電灯をプレイヤーの傍に移動させる
            explainScript.LightExplain();  //懐中電灯の説明画像を表示
        }
        //鍵を取得した時の処理
        else if (itemScript.itemType == "key")
        {
            itemTypeList.Add(itemScript.itemType);  //アイテムの種類を追加
            itemNameList.Add(itemScript.itemName);  //アイテムの名前を追加
            itemImageList.Add(itemScript.itemImage);  //アイテムの画像を追加
            if (itemImageList.Count == 2) canSlotMove = true;  //アイテムの数が１個の時はスロットを操作できない
            Slot();  //アイテム画像をスロットに格納
            explainScript.KeyExplain(itemScript);  //鍵の説明画像を表示
            Destroy(item);  //アイテムを削除

        }
        //回復薬を取得した時の処理
        else if (itemScript.itemType == "medicine")
        {
            if(medicineCount == 0)
            {
                itemTypeList.Add(itemScript.itemType);  //アイテムの種類を追加
                itemNameList.Add(itemScript.itemName);  //アイテムの名前を追加
                itemImageList.Add(itemScript.itemImage);  //アイテムの画像を追加
            }
            medicineCount += 1;
            if (itemImageList.Count == 2) canSlotMove = true;  //アイテムの数が１個の時はスロットを操作できない
            Slot();
            Destroy(item);
            if (explainScript.medicineCount == false) explainScript.MedicineExplain();  //回復薬の説明画像を表示
        }
        //強化薬を取得した時の処理
        else if (itemScript.itemType == "drug")
        {
            if(drugCount == 0)
            {
                itemTypeList.Add(itemScript.itemType);  //アイテムの種類を追加
                itemNameList.Add(itemScript.itemName);  //アイテムの名前を追加
                itemImageList.Add(itemScript.itemImage);  //アイテムの画像を追加
            }
            drugCount += 1;
            if (itemImageList.Count == 2) canSlotMove = true;  //アイテムの数が１個の時はスロットを操作できない
            Slot();
            Destroy(item);
            if (explainScript.drugCount == false) explainScript.DrugExplain();  //回復薬の説明画像を表示
        }
        //コインを取得した時の処理
        else if(itemScript.itemType == "coin")
        {
            kaiten.medal += item.GetComponent<CoinScript>().value;
            Destroy(item);
        }
        //オーバー鉱石を取得した時の処理
        else if (itemScript.itemType == "crystal")
        {
            explainScript.CrystalExplain();  //鍵の説明画像を表示
            Destroy(item);  //アイテムを削除
        }
        //オーパーツ設計書を取得した時の処理
        else if (itemScript.itemType == "build")
        {
            explainScript.BuildExplain();  //鍵の説明画像を表示
            Destroy(item);  //アイテムを削除
        }
    }
    public void Slot()  //アイテムスロットにアイテムを装填する
    {
        int count = listNumber;
        if (itemImageList.Count < 5) loop = itemImageList.Count;
        else if (itemImageList.Count >= 5) loop = slotImageList.Count;

        for (int i = 0; i < loop; i++)  //5回繰り返す
        {
            slotImageList[i].sprite = itemImageList[count];
            count += 1;
            if (count == itemImageList.Count) count = 0;

        }
    }
    public void SlotMove()  //アイテムスロット内のアイテムの配置を動かす
    {
        if (Input.GetKeyDown(KeyCode.E))  //アイテムを右に移動
        {
            listNumber += 1;
            if (listNumber == itemImageList.Count) listNumber = 0;
            Slot();
        }
        if (Input.GetKeyDown(KeyCode.Q))  //アイテムを左に移動
        {
            listNumber -= 1;
            if (listNumber < 0) listNumber = itemImageList.Count - 1;
            Slot();
        }
    }
    public void SlotSort()  //アイテムスロットの並び替え関数
    {
        listNumber = 0;
        for(int i = 0; i < slotImageList.Count; i++)
        {
            //対象のスロットに何も装填されておらず、となりのスロットに装填されている時
            if(slotImageList[i].sprite == blankImage && i < slotImageList.Count)
            {
                //対象のスロットの隣のスロットが存在している時
                if (slotImageList[i + 1].sprite != blankImage)
                {
                    slotImageList[i].sprite = slotImageList[i + 1].sprite;
                    slotImageList[i + 1].sprite = blankImage;
                }
            }
        }
    }
}
